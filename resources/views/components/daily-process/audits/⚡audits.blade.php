<?php

use Livewire\Component;
use App\Models\Sale;
use App\Models\CashRegister;
use App\Models\Gasto;
use Carbon\Carbon;

new class extends Component
{
    // Coincide con wire:model="date" en search.blade.php
    public $date;

    // Variables de Conteo (Cantidades)
    public $total_sales_number = 0;
    public $total_sales_number_cash = 0;
    public $total_sales_number_transfer = 0;
    public $total_sales_number_card = 0;

    // Variables de Dinero (Montos)
    public $total_sales_amount = 0;
    public $total_sales_amount_cash = 0;
    public $total_sales_amount_transfer = 0;
    public $total_sales_amount_card = 0;

    // Variables de Caja Física
    public $cash_opening = 0;
    public $cash_closing = 0;

    public function mount()
    {
        // Inicializa con la fecha actual y ejecuta el cálculo
        $this->date = Carbon::today()->toDateString();
        $this->calculateAudits();
    }

    // Se dispara automáticamente al cambiar la fecha en el input
    public function updatedDate()
    {
        $this->calculateAudits();
    }

    public function calculateAudits()
    {
        if (empty($this->date)) {
            $this->resetTotals();
            return;
        }

        // 1. OBTENER VENTAS ACTIVAS DEL DÍA (Excluyendo ventas anuladas)
        $ventasDelDia = Sale::whereDate('fecha', $this->date)
            ->where(function ($query) {
                $query->where('status', '!=', 'Anulada')
                      ->orWhereNull('status');
            })
            ->get();

        // 2. TOTALES GENERALES
        $this->total_sales_number = $ventasDelDia->count();
        $this->total_sales_amount = round($ventasDelDia->sum('totalPagado'), 2);

        // 3. EFECTIVO (Efectivo Puro + Porción en Efectivo de Ventas Mixtas)
        $this->total_sales_number_cash = $ventasDelDia->where('metodoPago', 'Efectivo')->count()
            + $ventasDelDia->where('metodoPago', 'Mixto')->where('mixed_cash_amount', '>', 0)->count();

        $this->total_sales_amount_cash = round(
            $ventasDelDia->where('metodoPago', 'Efectivo')->sum('totalPagado')
            + $ventasDelDia->where('metodoPago', 'Mixto')->sum('mixed_cash_amount'),
            2
        );

        // 4. TRANSFERENCIA (Transferencia Pura + Porción en Transferencia de Ventas Mixtas)
        $this->total_sales_number_transfer = $ventasDelDia->where('metodoPago', 'Transferencia Bancaria')->count()
            + $ventasDelDia->where('metodoPago', 'Mixto')->where('mixed_transfer_amount', '>', 0)->count();

        $this->total_sales_amount_transfer = round(
            $ventasDelDia->where('metodoPago', 'Transferencia Bancaria')->sum('totalPagado')
            + $ventasDelDia->where('metodoPago', 'Mixto')->sum('mixed_transfer_amount'),
            2
        );

        // 5. TARJETA (Tarjeta Pura + Porción en Tarjeta de Ventas Mixtas)
        $this->total_sales_number_card = $ventasDelDia->where('metodoPago', 'Tarjeta')->count()
            + $ventasDelDia->where('metodoPago', 'Mixto')->where('mixed_tarjeta_amount', '>', 0)->count();

        $this->total_sales_amount_card = round(
            $ventasDelDia->where('metodoPago', 'Tarjeta')->sum('totalPagado')
            + $ventasDelDia->where('metodoPago', 'Mixto')->sum('mixed_tarjeta_amount'),
            2
        );

        // 6. APERTURA DE CAJA
        // Si hay más de una apertura en el mismo día, suma opening_amount o toma el registro del día
        $this->cash_opening = round(
            CashRegister::whereDate('date', $this->date)->sum('opening_amount'),
            2
        );

        // 7. GASTOS QUE SALIERON DE LA GAVETA EN ESA FECHA
        $gastosDeCaja = round(
            Gasto::whereDate('fecha', $this->date)->where('from_cash_register', 'Si')->sum('monto'),
            2
        );

        // 8. CIERRE DE CAJA (Apertura + Ventas en Efectivo - Gastos de Gaveta)
        $this->cash_closing = round(($this->cash_opening + $this->total_sales_amount_cash) - $gastosDeCaja, 2);
    }

    public function resetTotals()
    {
        $this->total_sales_number = 0;
        $this->total_sales_number_cash = 0;
        $this->total_sales_number_transfer = 0;
        $this->total_sales_number_card = 0;
        $this->total_sales_amount = 0;
        $this->total_sales_amount_cash = 0;
        $this->total_sales_amount_transfer = 0;
        $this->total_sales_amount_card = 0;
        $this->cash_opening = 0;
        $this->cash_closing = 0;
    }
};
?>

<div>
    <!-- Fila de Búsqueda (Fecha) -->
    <div class="mb-6">
        @include('components.daily-process.audits.search')
    </div>

    <!-- Títulos de las Secciones -->
    <div class="lg:grid grid-cols-4 sm:grid-col-1 gap-4 mb-2 px-3">
        <!-- Título para las dos primeras columnas (Ventas) -->
        <div class="col-span-2">
            <h2 class="text-lg font-bold text-gray-800 border-b-2 border-gray-200 pb-1 w-full text-center">Ventas</h2>
        </div>
        
        <!-- Título para las dos últimas columnas (Caja) -->
        <div class="col-span-2">
            <h2 class="text-lg font-bold text-gray-800 border-b-2 border-blue-500 pb-1 w-full text-center underline">Caja</h2>
        </div>
    </div>

    <!-- Contenido de los datos -->
    <div class="lg:grid grid-cols-4 sm:grid-col-1 gap-4">
        
        {{-- primer columna (Cantidades de Ventas) --}}
        <div>
            @include('components.daily-process.audits.sales.first')
        </div>

        {{-- segunda columna (Montos de Ventas) --}}
        <div>
            @include('components.daily-process.audits.sales.second')
        </div>

        {{-- tercer columna (Apertura de Caja) --}}
        <div>
            @include('components.daily-process.audits.cashier.first')
        </div>

        {{-- cuarta columna (Cierre de Caja) --}}
        <div>
            @include('components.daily-process.audits.cashier.second')
        </div>
    </div>
</div>
