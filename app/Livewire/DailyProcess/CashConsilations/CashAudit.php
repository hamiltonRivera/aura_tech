<?php

namespace App\Livewire\DailyProcess\CashConsilations;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Sale;
use Livewire\WithPagination;

class CashAudit extends Component
{
    use WithPagination;

    public $search_audit = '';

    //Si necesitas auditar días anteriores luego, puedes usar esta variable
    public $fechaAuditoria; 

    public function mount()
    {
        // Por defecto, auditar el día de hoy
        $this->fechaAuditoria = Carbon::today()->format('Y-m-d');
    }

    // Resetear paginación cuando se busca algo
    public function updatingSearchAudit()
    {
        $this->resetPage();
    }


    public function render()
    {  
        // Recuperar ventas solo en efectivo, de la fecha seleccionada
        $ventas = Sale::whereDate('created_at', $this->fechaAuditoria)
            ->where('metodoPago', 'Efectivo') // Ajusta 'metodoPago' si tu columna se llama distinto
            ->where(function($query) {
                // Lógica del buscador por número de factura
               $query->where('numFactura', 'like', '%' . $this->search_audit . '%');
            })
            // Ordenar de las más recientes a las más antiguas
            ->orderBy('created_at', 'desc') 
            // Paginación a 10 registros
            ->paginate(10);
        return view('livewire.daily-process.cash-consilations.cash-audit', compact('ventas'));
    }


}
