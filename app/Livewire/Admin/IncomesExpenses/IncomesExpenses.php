<?php

namespace App\Livewire\Admin\IncomesExpenses;

use Livewire\Component;
use App\Models\Gasto;
use App\Models\Sale;
use App\Models\CreditPayment;

class IncomesExpenses extends Component
{
    public $mostrarVentaProductos = false, $mostrarVentaServicios = false, $mostrarVentaTotales = false, $fecha, $cierre, $gasto_dia, $fecha_gasto,
    $balance, $mostrarGastos = false, $mostrarBusquedaPersonalizada = false, $fecha_inicio, $fecha_fin, $custom_date,
    $fecha_abono, $abono_dia, $mostrarBalance = false;

    public $fecha_efectivo, $fecha_transferencia, $cierre_efectivo, $cierre_transferencia;
    // NUEVAS VARIABLES PARA TARJETA
    public $fecha_tarjeta, $cierre_tarjeta;
    
    public $payments = false;

    public $fechaTotalServicio, $cierreServicio, $fechaTotalServicioEfectivo, $cierreServicioEfectivo,
    $fechaServicioTransferencia, $cierreServicioTransferencia;

    public $fechaTotalGeneral, $cierreTotalGeneral, $totalGeneralProducto, $totalGeneralServicio;

    public $fecha_abono_efectivo, $cierre_abono_efectivo;
    public $fecha_abono_transferencia, $cierre_abono_transferencia;

    // Propiedades para el módulo Balance
    public $start_date_ingresos, $end_date_ingresos;
    public $start_date_egresos, $end_date_egresos;
    public $total_ingresos = 0, $total_egresos = 0, $diferencia_balance = 0;

    public function render()
    {
        return view('livewire.admin.incomes-expenses.incomes-expenses');
    }

    public function show_balance()
    {
        $this->mostrarVentaProductos = false;
        $this->mostrarVentaServicios = false;
        $this->mostrarVentaTotales = false;
        $this->mostrarGastos = false;
        $this->mostrarBusquedaPersonalizada = false;
        $this->payments = false;
        $this->mostrarBalance = true;
    }

    public function calcularBalance()
    {
        $ingresos = 0;
        $egresos = 0;

        if ($this->start_date_ingresos && $this->end_date_ingresos) {
            $ingresos = Sale::whereBetween('fecha', [$this->start_date_ingresos, $this->end_date_ingresos])->sum('totalPagado');
        }

        if ($this->start_date_egresos && $this->end_date_egresos) {
            $egresos = Gasto::whereBetween('fecha', [$this->start_date_egresos, $this->end_date_egresos])->sum('monto');
        }

        $this->total_ingresos = $ingresos;
        $this->total_egresos = $egresos;
        $this->diferencia_balance = $ingresos - $egresos;
    }

    public function mostrarEgresos()
    {
        $this->mostrarVentaProductos = false;
        $this->mostrarVentaServicios = false;
        $this->mostrarVentaTotales = false;
        $this->mostrarGastos = true;
        $this->mostrarBusquedaPersonalizada = false;
        $this->payments = false;
        $this->mostrarBalance = false;
    }

    public function mostrarVentaProducto()
    {
        $this->mostrarVentaProductos = true;
        $this->mostrarVentaServicios = false;
        $this->mostrarVentaTotales = false;
        $this->mostrarGastos = false;
        $this->mostrarBusquedaPersonalizada = false;
        $this->payments = false;
        $this->mostrarBalance = false;
    }

    public function mostrarVentaServicio()
    {
       $this->mostrarVentaProductos = false;
       $this->mostrarVentaServicios = true;
       $this->mostrarVentaTotales = false;
       $this->mostrarGastos = false;
       $this->mostrarBusquedaPersonalizada = false;
       $this->payments = false;
       $this->mostrarBalance = false;
    }

    public function mostrarVentaTotal()
    {
        $this->mostrarVentaProductos = false;
        $this->mostrarVentaServicios = false;
        $this->mostrarVentaTotales = true;
        $this->mostrarGastos = false;
        $this->mostrarBusquedaPersonalizada = false;
        $this->payments = false;
        $this->mostrarBalance = false;
    }

    public function limpiarEntorno()
    {
        // 1. Apagar todas las vistas
        $this->mostrarVentaProductos = false;
        $this->mostrarGastos = false;
        $this->mostrarBusquedaPersonalizada = false;
        $this->mostrarVentaServicios = false;
        $this->mostrarVentaTotales = false;
        $this->payments = false;
        $this->mostrarBalance = false;

        // 2. Limpiar inputs de fechas y resultados de cálculos
        $this->fecha = null;
        $this->cierre = null;
        $this->gasto_dia = null;
        $this->fecha_gasto = null;
        $this->fecha_inicio = null;
        $this->fecha_fin = null;
        $this->custom_date = null;
        $this->fecha_abono = null;
        $this->abono_dia = null;

        $this->fecha_efectivo = null;
        $this->fecha_transferencia = null;
        $this->cierre_efectivo = null;
        $this->cierre_transferencia = null;
        
        // Limpiar inputs de tarjeta
        $this->fecha_tarjeta = null;
        $this->cierre_tarjeta = null;

        $this->fechaTotalServicio = null;
        $this->cierreServicio = null;
        $this->fechaTotalServicioEfectivo = null;
        $this->cierreServicioEfectivo = null;
        $this->fechaServicioTransferencia = null;
        $this->cierreServicioTransferencia = null;

        $this->fechaTotalGeneral = null;
        $this->cierreTotalGeneral = null;
        $this->totalGeneralProducto = null;
        $this->totalGeneralServicio = null;

        $this->fecha_abono_efectivo = null;
        $this->cierre_abono_efectivo = null;
        $this->fecha_abono_transferencia = null;
        $this->cierre_abono_transferencia = null;

        // 3. Limpiar variables de Balance
        $this->start_date_ingresos = null;
        $this->end_date_ingresos = null;
        $this->start_date_egresos = null;
        $this->end_date_egresos = null;
        $this->total_ingresos = 0;
        $this->total_egresos = 0;
        $this->diferencia_balance = 0;
    }

    public function busquedaPersonalizada()
    {
        $this->mostrarVentaProductos = false;
        $this->mostrarVentaServicios = false;
        $this->mostrarVentaTotales = false;
        $this->mostrarGastos = false;
        $this->mostrarBusquedaPersonalizada = true;
        $this->payments = false;
        $this->mostrarBalance = false;
    }

    public function show_credits_payments()
    {
        $this->mostrarVentaProductos = false;
        $this->mostrarVentaServicios = false;
        $this->mostrarVentaTotales = false;
        $this->mostrarGastos = false;
        $this->mostrarBusquedaPersonalizada = false;
        $this->payments = true;
        $this->mostrarBalance = false;
    }

    public function gastoDelDia()
    {
        $gastos = Gasto::whereFecha($this->fecha_gasto)->get();
        $this->gasto_dia = $gastos->sum('monto');
    }

    public function cierreDelDia()
    {
        $ventas = Sale::whereFecha($this->fecha)->get();
        $this->cierre = $ventas->sum('totalPagado');
    }

    public function cierreEfectivo()
    {
        // 1. Suma las ventas que fueron 100% Efectivo
        $ventasEfectivoPuro = Sale::whereFecha($this->fecha_efectivo)
                                  ->where('metodoPago', 'Efectivo')
                                  ->sum('totalPagado');

        // 2. Extraer solo el efectivo físico de las ventas Mixtas
        $ventasMixtasEfectivo = Sale::whereFecha($this->fecha_efectivo)
                                    ->where('metodoPago', 'Mixto')
                                    ->sum('mixed_cash_amount');

        // 3. Total en Gaveta
        $this->cierre_efectivo = $ventasEfectivoPuro + $ventasMixtasEfectivo;
    }

    public function cierreTransferencia()
    {
        // 1. Ventas que fueron 100% Transferencia Bancaria
        $ventasTransferenciaPura = Sale::whereFecha($this->fecha_transferencia)
                                       ->where('metodoPago', 'Transferencia Bancaria')
                                       ->sum('totalPagado');

        // 2. Extraer solo la porción digital de las ventas Mixtas
        $ventasMixtasDigital = Sale::whereFecha($this->fecha_transferencia)
                                   ->where('metodoPago', 'Mixto')
                                   ->sum('mixed_transfer_amount');

        // 3. Total en Banco (por transferencias)
        $this->cierre_transferencia = $ventasTransferenciaPura + $ventasMixtasDigital;
    }

    public function cierreTarjeta()
    {
        // Suma directa de las ventas 100% con Tarjeta
        $this->cierre_tarjeta = Sale::whereFecha($this->fecha_tarjeta)
                                    ->where('metodoPago', 'Tarjeta')
                                    ->sum('totalPagado');
    }

    public function cierreDelDiaGeneral()
    {
        $totalProducto = Sale::whereFecha($this->fechaTotalGeneral)->sum('totalPagado');
        $this->totalGeneralProducto = $totalProducto;
        $this->cierreTotalGeneral = $this->totalGeneralProducto;
    }

    public function abonoDelDia()
    {
        $this->abono_dia = CreditPayment::whereDate('payment_date', $this->fecha_abono)->sum('amount_paid');
    }

    public function customResearching()
    {
        $totalVentasCustom = Sale::whereBetween('fecha', [$this->fecha_inicio, $this->fecha_fin])->sum('totalPagado');
        $totalVentasFormateado = number_format($totalVentasCustom, 2, '.', ',');
        $this->custom_date = $totalVentasFormateado;
    }

    public function cierreAbonoEfectivo()
    {
        $this->cierre_abono_efectivo = CreditPayment::whereDate('payment_date', $this->fecha_abono_efectivo)
            ->where('payment_method', 'Efectivo')
            ->sum('amount_paid');
    }

    public function cierreAbonoTransferencia()
    {
        $this->cierre_abono_transferencia = CreditPayment::whereDate('payment_date', $this->fecha_abono_transferencia)
            ->where('payment_method', 'Transferencia Bancaria')
            ->sum('amount_paid');
    }
}
