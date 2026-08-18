<?php

namespace App\Livewire\DailyProcess\ProductsMostSold;

use App\Models\Product;
use Livewire\Component;
use App\Models\ProductSale;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
class ProductsMostSold extends Component
{
    use WithPagination;

    public $search ='', $start_date, $end_date;
    public function render()
    {
        if ($this->start_date && $this->end_date) {
            $query = DB::table('product_sales')
                ->join('products', 'product_sales.product_id', '=', 'products.id')
                ->select('products.*', DB::raw('SUM(product_sales.quantity_sold) as total_sold'))
                ->whereBetween('product_sales.date', [$this->start_date, $this->end_date])
                ->groupBy('products.id')
                ->orderBy('total_sold', 'desc');

            $products = $query->paginate(10);
        } else {
            $products = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);
        }

        return view('livewire.daily-process.products-most-sold.products-most-sold', compact('products'));
    }

    public function clear_fields()
    {
        $this->start_date = false;
        $this->end_date = false;
    }


}






