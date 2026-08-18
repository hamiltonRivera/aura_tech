<?php

namespace App\Livewire\Admin\OrdersDone;

use Livewire\Component;
use App\Models\Order;
use Livewire\WithPagination;
class OrdersDone extends Component
{

    use WithPagination;
    public $search = '';

    public function render()
    {
        $orders = Order::with('provider')->orderBy('id', 'asc')
         ->whereRelation('provider', 'nombreApellido', 'like', '%' . $this->search . '%')
         ->orWhere('fecha', 'like', '%' .$this->search . '%')
         ->orWhere('metodoPago', 'like', '%' . $this->search . '%')->paginate(10);
        return view('livewire.admin.orders-done.orders-done', compact('orders'));
    }
}
