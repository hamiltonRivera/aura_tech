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
    public function render()
    {
        $sales = Sale::with('user', 'client')
         ->whereRelation('user', 'name', 'like', '%' . $this->search . '%')
         ->orWhereRelation('client', 'nombreApellido', 'like', '%' . $this->search . '%')
         ->orWhereAny(['fecha', 'numFactura', 'metodoPago'], 'like', '%' . $this->search . '%')->paginate(10);
        return view('livewire.daily-process.sales-done.sales-done', compact('sales'));
    }
}
