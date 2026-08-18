<?php

namespace App\Livewire\DailyProcess\Credits;

use Livewire\Component;
use App\Models\Product;
use App\Models\Client;
use App\Models\CreditSale;
use App\Models\CreditDetail;
use App\Models\ProductSale;
use Livewire\WithPagination;
class Credits extends Component
{
    use WithPagination;
    public $search = '';
    public function render()
    {
        $sales = CreditSale::with('user', 'client')
            ->whereRelation('user', 'name', 'like', '%' . $this->search . '%')
            ->orWhereRelation('client', 'nombreApellido', 'like', '%' . $this->search . '%')
            ->orWhereAny(['date', 'voucher_number'], 'like', '%' . $this->search . '%')->paginate(10);
        return view('livewire.daily-process.credits.credits', compact('sales'));
    }
}
