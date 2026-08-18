<?php

namespace App\Livewire\DailyProcess\Products;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;
class ProductsNoStock extends Component
{
    use WithPagination;

      public $search = '';
    public function render()
    {
        $products = Product::where('stock', '=', '0')
        ->where('descripcion', 'like', '%' . $this->search . '%')->paginate(10);
        return view('livewire.daily-process.products.products-no-stock', compact('products'));
    }
}
