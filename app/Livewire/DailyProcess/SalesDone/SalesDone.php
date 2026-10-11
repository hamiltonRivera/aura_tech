<?php

namespace App\Livewire\DailyProcess\SalesDone;

use Livewire\Component;
use App\Models\Sale;
use Livewire\WithPagination;
class SalesDone extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';
    public $search = '';
    public $filterDate = '';
    public $filterMethod = '';
    public $totalSuma = 0;

    public $metodos = [
        'Efectivo',
        'Transferencia Bancaria',
        'Efectivo Mixto', //mixed_cash_amount
        'Tarjeta Mixto', //mixed_transfer_amount
        'Transferencia Mixto', //mixed_tarjeta_amount
        'Tarjeta'
    ];
    public function render()
    {
        $query = Sale::with('user', 'client');

        // Mantenemos tu búsqueda de texto original agrupada
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->whereRelation('user', 'name', 'like', '%' . $this->search . '%')
                  ->orWhereRelation('client', 'nombreApellido', 'like', '%' . $this->search . '%')
                  ->orWhereAny(['fecha', 'numFactura', 'metodoPago'], 'like', '%' . $this->search . '%');
            });
        }

        // 1. APLICAMOS EL FILTRO DE FECHA
        if (!empty($this->filterDate)) {
            $query->whereDate('fecha', $this->filterDate);
        }

        // 2. APLICAMOS EL FILTRO DE MÉTODO DE PAGO
        if (!empty($this->filterMethod)) {
            $query->where('metodoPago', $this->filterMethod);
        }

        // CALCULAMOS EL TOTAL: Esta línea toma en cuenta ambos filtros automáticamente
        $this->totalSuma = (clone $query)->sum('totalPagado');

        $sales = $query->paginate(10);

        return view('livewire.daily-process.sales-done.sales-done', compact('sales'));
    }
}
