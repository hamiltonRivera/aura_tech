<?php

namespace App\Livewire\DailyProcess\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
class ProductsInStock extends Component
{

    use WithPagination;

      public $search = '';
    public function render()
    {
        $products = Product::where('stock', '>=', '1')
        ->where('descripcion', 'like', '%' . $this->search . '%')->paginate(10);
        return view('livewire.daily-process.products.products-in-stock', compact('products'));
    }
}
