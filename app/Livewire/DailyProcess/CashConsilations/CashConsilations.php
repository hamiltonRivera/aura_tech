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

    public $date;
    public $opening_amount;
    public $last_closing_amount;
    public $closing_amount;
    public $is_opening_locked = false;

    // Variables de control
    public $has_surplus = 'no';
    public $physical_amount; 
    public $difference; 
    public $excedent_justification;

    public function mount()
    {
        $this->date = Carbon::today()->format('Y-m-d');
        $this->checkExistingOpening(); 
    }

    public function updatedDate()
    {
        $this->checkExistingOpening();
    }

    public function checkExistingOpening()
    {
        $primerArqueo = CashRegister::whereDate('date', $this->date)->first();

        if ($primerArqueo) {
            $this->opening_amount = $primerArqueo->opening_amount;
            $this->is_opening_locked = true;
        } else {
            $this->opening_amount = null; 
            $this->is_opening_locked = false;
        }
    }

    public function updatedHasSurplus($value)
    {
        if ($value == 'no') {
            $this->difference = 0;
            $this->physical_amount = $this->closing_amount;
            $this->excedent_justification = null;
        } else {
            $this->difference = null; 
            $this->physical_amount = $this->closing_amount; 
        }
    }

    public function updatedDifference()
    {
        if ($this->closing_amount !== null) {
            $diff = floatval($this->difference ?? 0);
            $this->physical_amount = round(floatval($this->closing_amount) + $diff, 2);
        }
    }

    public function render()
    {
        $arqueos = CashRegister::with('user')
            ->where('date', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'asc')
            ->paginate(5);
            
        return view('livewire.daily-process.cash-consilations.cash-consilations', compact('arqueos'));
    }

    public function refresh()
    {
        return redirect('/private/cash-reconciliation');
    }

    public function storecalculate()
    {
        $this->validate([
            'opening_amount' => 'required|numeric'
        ], [
            'opening_amount.required' => 'Debe ingresar el monto de apertura para calcular.'
        ]);

        $fechaSeleccionada = $this->date ?: Carbon::today()->format('Y-m-d');
        $fechaAyer = Carbon::parse($fechaSeleccionada)->subDay()->format('Y-m-d');

        // 1. Cierre anterior (ayer): Toma el cierre real registrado ayer, o calcula ventas activas de ayer
        $arqueoAyer = CashRegister::whereDate('date', $fechaAyer)->latest('id')->first();
        if ($arqueoAyer) {
            $this->last_closing_amount = round($arqueoAyer->closing_amount, 2);
        } else {
            $ayerPuras = Sale::whereDate('fecha', $fechaAyer)
                ->where(function ($q) {
                    $q->where('status', '!=', 'Anulada')->orWhereNull('status');
                })
                ->where('metodoPago', 'Efectivo')
                ->sum('totalPagado');

            $ayerMixtas = Sale::whereDate('fecha', $fechaAyer)
                ->where(function ($q) {
                    $q->where('status', '!=', 'Anulada')->orWhereNull('status');
                })
                ->where('metodoPago', 'Mixto')
                ->sum('mixed_cash_amount');

            $this->last_closing_amount = round(floatval($ayerPuras) + floatval($ayerMixtas), 2);
        }

        // 2. Ventas en efectivo de hoy (puras + mixtas) excluyendo ventas anuladas
        $ventasHoyPuras = Sale::whereDate('fecha', $fechaSeleccionada)
            ->where(function ($q) {
                $q->where('status', '!=', 'Anulada')->orWhereNull('status');
            })
            ->where('metodoPago', 'Efectivo')
            ->sum('totalPagado');

        $ventasHoyMixtas = Sale::whereDate('fecha', $fechaSeleccionada)
            ->where(function ($q) {
                $q->where('status', '!=', 'Anulada')->orWhereNull('status');
            })
            ->where('metodoPago', 'Mixto')
            ->sum('mixed_cash_amount');

        $ventasHoy = floatval($ventasHoyPuras) + floatval($ventasHoyMixtas);
        $apertura = floatval($this->opening_amount); 

        // Base de caja = Apertura + Ventas en efectivo
        $this->closing_amount = round($apertura + $ventasHoy, 2);
        
        if ($this->has_surplus == 'no') {
            $this->difference = 0;
            $this->physical_amount = $this->closing_amount;
        } else {
            $excedente = floatval($this->difference ?? 0);
            $this->physical_amount = round($this->closing_amount + $excedente, 2);
        }
    }

    public function store()
    {
        $this->validate([
            'date' => 'required|date',
            'opening_amount' => 'required|numeric|min:0',
        ], [
            'opening_amount.required' => 'El monto de apertura es obligatorio.',
        ]);

        // Recalculamos todo limpio antes de guardar
        $this->storecalculate();

        // Manejo de excedente
        if ($this->has_surplus == 'si') {
            $this->validate([
                'difference' => 'required|numeric|min:0.01',
                'excedent_justification' => 'required|string|min:3|max:255',
            ], [
                'difference.required' => 'Debe ingresar el monto del excedente.',
                'difference.min' => 'El excedente debe ser mayor a 0.',
                'excedent_justification.required' => 'Debe escribir una justificación para el excedente.'
            ]);

            $this->difference = floatval($this->difference);
            $this->physical_amount = round($this->closing_amount + $this->difference, 2);
        } else {
            $this->difference = 0;
            $this->physical_amount = $this->closing_amount;
            $this->excedent_justification = null;
        }

        // Calculamos transferencias del día para dejar constancia en el ActivityLog
        $fechaSeleccionada = $this->date ?: Carbon::today()->format('Y-m-d');
        $transferenciasHoy = Sale::whereDate('fecha', $fechaSeleccionada)
            ->where(function ($q) {
                $q->where('status', '!=', 'Anulada')->orWhereNull('status');
            })
            ->where('metodoPago', 'Transferencia Bancaria')
            ->sum('totalPagado')
            + Sale::whereDate('fecha', $fechaSeleccionada)
            ->where(function ($q) {
                $q->where('status', '!=', 'Anulada')->orWhereNull('status');
            })
            ->where('metodoPago', 'Mixto')
            ->sum('mixed_transfer_amount');

        CashRegister::create([
            'date' => $this->date,
            'opening_amount' => $this->opening_amount,
            'last_closing_amount' => $this->last_closing_amount,
            'closing_amount' => $this->closing_amount,
            'physical_amount' => $this->physical_amount,
            'difference' => $this->difference,
            'excedent_justification' => $this->excedent_justification,
            'user_id' => auth()->id(),
        ]);
        
        $newActivity = new ActivityLog();
        $newActivity->user_id = auth()->user()->id;
        $newActivity->activity = "Nuevo Registro - Arqueo de Caja";
        $newActivity->detail = "Cierre Sistema (Apertura+Efectivo): C$ " . $this->closing_amount 
                             . " | Físico Reportado: C$ " . $this->physical_amount 
                             . " | Excedente: C$ " . $this->difference 
                             . " | Transferencias del día (No van en caja): C$ " . round($transferenciasHoy, 2);
        $newActivity->save();

        $this->resetPage();
        Alert::success('Arqueo Registrado', 'El cierre de caja se ha guardado correctamente.');
        $this->refresh();
    }
}
