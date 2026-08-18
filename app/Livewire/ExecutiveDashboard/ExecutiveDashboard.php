<?php

namespace App\Livewire\ExecutiveDashboard;

use Livewire\Component;
use App\Models\Sale;
use App\Models\CreditPayment;
use App\Models\Product;
use App\Models\Client;
use Carbon\Carbon;

class ExecutiveDashboard extends Component
{
    public $totalSalesToday;
    public $totalSalesThisMonth;
    public $totalSalesThisYear;
    public $topProducts;
    public $totalClients;
    public $totalProducts;
    public $lowStockProducts;
    public $expiringProducts;

    protected $listeners = ['echo:sales,SaleCreated' => 'loadData'];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        // Ingresos de hoy (ventas + abonos a créditos)
        $salesToday = Sale::whereDate('fecha', today())->sum('totalPagado');
        $creditPaymentsToday = CreditPayment::whereDate('payment_date', today())->sum('amount_paid');
        $this->totalSalesToday = $salesToday + $creditPaymentsToday;

        // Ingresos del mes (ventas + abonos a créditos)
        $salesThisMonth = Sale::whereYear('fecha', now()->year)
            ->whereMonth('fecha', now()->month)
            ->sum('totalPagado');
        $creditPaymentsThisMonth = CreditPayment::whereYear('payment_date', now()->year)
            ->whereMonth('payment_date', now()->month)
            ->sum('amount_paid');
        $this->totalSalesThisMonth = $salesThisMonth + $creditPaymentsThisMonth;

            // Ventas del año (ventas + abonos a créditos)
            $salesThisYear = Sale::whereYear('fecha', now()->year)->sum('totalPagado');
            $creditPaymentsThisYear = CreditPayment::whereYear('payment_date', now()->year)->sum('amount_paid');
            $this->totalSalesThisYear = $salesThisYear + $creditPaymentsThisYear;

        // Productos más vendidos (últimos 30 días)
        $this->topProducts = \DB::table('products')
            ->join('product_sales', 'products.id', '=', 'product_sales.product_id')
            ->select('products.descripcion', \DB::raw('SUM(product_sales.quantity_sold) as total_sold'))
            ->where('product_sales.created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('products.id', 'products.descripcion')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        // Total clientes
        $this->totalClients = Client::count();

        // Total productos
        $this->totalProducts = Product::count();

        // Productos con stock bajo (menos de 10)
        $this->lowStockProducts = Product::where('stock', '<', 10)->orderBy('stock', 'asc')->limit(5)->get();

        // Productos próximos a vencer (próximos 20 días)
        $this->expiringProducts = Product::where('fecha_vencimiento', '>=', now())
            ->where('fecha_vencimiento', '<=', now()->addDays(20))
            ->orderBy('fecha_vencimiento', 'asc')
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.executive-dashboard.executive-dashboard');
    }
}
