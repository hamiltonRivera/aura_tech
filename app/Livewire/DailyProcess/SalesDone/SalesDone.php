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
        'Efectivo Mixto',
        'Tarjeta Mixto',
        'Transferencia Mixto',
        'Tarjeta'
    ];

    public function render()
    {
        $query = Sale::with('user', 'client');

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->whereRelation('user', 'name', 'like', '%' . $this->search . '%')
                  ->orWhereRelation('client', 'nombreApellido', 'like', '%' . $this->search . '%')
                  ->orWhereAny(['fecha', 'numFactura', 'metodoPago'], 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->filterDate)) {
            $query->whereDate('fecha', $this->filterDate);
        }

        $columnaASumar = 'totalPagado';

        if (!empty($this->filterMethod)) {
            if (in_array($this->filterMethod, ['Efectivo Mixto', 'Transferencia Mixto', 'Tarjeta Mixto'])) {
                $query->where('metodoPago', 'Mixto');

                if ($this->filterMethod === 'Efectivo Mixto') {
                    $columnaASumar = 'mixed_cash_amount';
                    $query->where('mixed_cash_amount', '>', 0); 
                } elseif ($this->filterMethod === 'Transferencia Mixto') {
                    $columnaASumar = 'mixed_transfer_amount';
                    $query->where('mixed_transfer_amount', '>', 0);
                } elseif ($this->filterMethod === 'Tarjeta Mixto') {
                    $columnaASumar = 'mixed_tarjeta_amount';
                    $query->where('mixed_tarjeta_amount', '>', 0);
                }
            } else {
                $query->where('metodoPago', $this->filterMethod);
            }
        }

        $this->totalSuma = (clone $query)->sum($columnaASumar);

        $sales = $query->paginate(10);
        
        // Pasamos todo limpio por el compact
        $filterMethod = $this->filterMethod;
        $metodos = $this->metodos;

        return view('livewire.daily-process.sales-done.sales-done', compact('sales', 'filterMethod', 'metodos'));
    }
}