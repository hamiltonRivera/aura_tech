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
    public $fechaAuditoria; 

    public function mount()
    {
        // Por defecto, auditar el día de hoy
        $this->fechaAuditoria = Carbon::today()->format('Y-m-d');
    }

    public function updatingSearchAudit()
    {
        $this->resetPage();
    }

    public function render()
    {  
        // Consulta base con los filtros de fecha y método de pago
        $query = Sale::whereDate('created_at', $this->fechaAuditoria)
            ->where('metodoPago', 'Efectivo')
            ->where(function($q) {
                $q->where('numFactura', 'like', '%' . $this->search_audit . '%');
            });

        // 1. Calculamos la suma total acumulada de todas las ventas en efectivo
        $total_efectivo = (clone $query)->sum('totalPagado');

        // 2. Obtenemos las ventas paginadas ordenadas por hora
        $ventas = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.daily-process.cash-consilations.cash-audit', compact('ventas', 'total_efectivo'));
    }
}