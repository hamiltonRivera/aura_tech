<?php

namespace App\Livewire\DailyProcess\CashConsilations;


use App\Models\ActivityLog;
use RealRashid\SweetAlert\Facades\Alert;
use Livewire\WithPagination;
use Livewire\Component;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\CashRegister;
class CashConsilations extends Component
{  
    use WithPagination;
    public $search = '';

    // Variables mapeadas desde los wire:model de tus vistas
    public $date;
    public $opening_amount;
    public $last_closing_amount;
    public $closing_amount;

    // Agrega esta nueva variable junto a las demás
    public $is_opening_locked = false;

    public function mount()
    {
        $this->date = Carbon::today()->format('Y-m-d');
        $this->checkExistingOpening(); // Revisamos si ya abrió caja hoy
    }

    // Este método mágico de Livewire se ejecuta si el usuario cambia la fecha en el calendario
    public function updatedDate()
    {
        $this->checkExistingOpening();
    }

    // Lógica para bloquear o liberar el campo
    public function checkExistingOpening()
    {
        // Buscamos el primer registro de la fecha seleccionada
        $primerArqueo = \App\Models\CashRegister::whereDate('date', $this->date)->first();

        if ($primerArqueo) {
            // Si ya hay un arqueo, copiamos el monto inicial y bloqueamos el input
            $this->opening_amount = $primerArqueo->opening_amount;
            $this->is_opening_locked = true;
        } else {
            // Si no hay arqueos en este día, dejamos el campo libre
            $this->opening_amount = null; // o 0, como prefieras
            $this->is_opening_locked = false;
        }
    }

    public function render()
    {
        $arqueos = CashRegister::with('user')
            ->where('date', 'like', '%' . $this->search . '%')
            ->orderBy('date', 'desc')
            ->paginate(5);
        return view('livewire.daily-process.cash-consilations.cash-consilations', compact('arqueos'));
    }

    public function refresh()
    {
        return redirect('/private/cash-reconciliation');
    }

    public function storecalculate()
    {
        // Valida que el campo de apertura no esté vacío antes de calcular
        $this->validate([
            'opening_amount' => 'required|numeric'
        ], [
            'opening_amount.required' => 'Debe ingresar el monto de apertura para calcular.'
        ]);

        // 1. Calcular cierre anterior (Ventas en efectivo de ayer)
        $this->last_closing_amount = Sale::whereDate('created_at', Carbon::yesterday())
            ->where('metodoPago', 'Efectivo') // Reemplaza 'metodoPago' por el nombre real de tu columna
            ->sum('totalPagado'); // Reemplaza 'totalPagado' por tu columna de total

        // 2. Calcular cierre actual (Apertura + Ventas en efectivo de hoy)
        $ventasHoy = Sale::whereDate('created_at', Carbon::today())
            ->where('metodoPago', 'Efectivo')
            ->sum('totalPagado');

        $apertura = floatval($this->opening_amount); 
        $this->closing_amount = $apertura + $ventasHoy;
    }

    public function store()
    {
        // 1. Validamos que los montos y la fecha estén presentes y sean correctos
        $this->validate([
            'date' => 'required|date',
            'opening_amount' => 'required|numeric',
            'last_closing_amount' => 'required|numeric',
            'closing_amount' => 'required|numeric',
        ]);

        // 2. Guardamos el registro en la base de datos
        CashRegister::create([
            'date' => $this->date,
            'opening_amount' => $this->opening_amount,
            'last_closing_amount' => $this->last_closing_amount,
            'closing_amount' => $this->closing_amount,
            'user_id' => auth()->id(), // Captura automáticamente el ID del administrador/usuario en sesión
        ]);

        
        $newActivity = new ActivityLog();
        $newActivity->user_id = auth()->user()->id;
        $newActivity->activity = "Nuevo Registro - Arqueo de Caja";
        $newActivity->detail = "Nuevo Registro - Arqueo de Caja";
        $newActivity->save();


        // 3. Disparamos la alerta de éxito usando el paquete SweetAlert que ya tienes
        Alert::success('Arqueo Registrado', 'El cierre de caja se ha guardado correctamente.');

        // 4. Redirigimos o refrescamos la vista
        $this->refresh();
    }

    
}
