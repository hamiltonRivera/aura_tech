<?php

namespace App\Livewire\Admin\IncomesExpenses;

use Livewire\Component;
use App\Models\Gasto;
use App\Models\Sale;
use App\Models\CreditPayment;
class IncomesExpenses extends Component
{
    public $mostrarVentaProductos = false,$mostrarVentaServicios = false, $mostrarVentaTotales = false, $fecha, $cierre, $gasto_dia, $fecha_gasto,
    $balance, $mostrarGastos = false, $mostrarBusquedaPersonalizada = false, $fecha_inicio, $fecha_fin, $custom_date,
    $fecha_abono, $abono_dia;

    public  $fecha_efectivo, $fecha_transferencia, $cierre_efectivo,$cierre_transferencia;
    public $payments = false;
    //servicios totales, efectivo y transferencia
    public $fechaTotalServicio, $cierreServicio, $fechaTotalServicioEfectivo, $cierreServicioEfectivo,
    $fechaServicioTransferencia, $cierreServicioTransferencia;

    //total general
    public $fechaTotalGeneral, $cierreTotalGeneral, $totalGeneralProducto, $totalGeneralServicio;

    public $fecha_abono_efectivo, $cierre_abono_efectivo;
    public $fecha_abono_transferencia, $cierre_abono_transferencia;


    public function render()
    {
        return view('livewire.admin.incomes-expenses.incomes-expenses');
    }

    public function mostrarEgresos()
    {
        $this->mostrarVentaProductos = false;
        $this->mostrarVentaServicios = false;
        $this->mostrarVentaTotales = false;
        $this->mostrarGastos = true;
        $this->mostrarBusquedaPersonalizada = false;
        $this->payments = false;
    }

    public function mostrarVentaProducto()
    {
        $this->mostrarVentaProductos = true;
        $this->mostrarVentaServicios = false;
        $this->mostrarVentaTotales = false;
        $this->mostrarGastos = false;
        $this->mostrarBusquedaPersonalizada = false;
        $this->payments = false;
    }

    public function mostrarVentaServicio()
    {
        $this->mostrarVentaServicios = true;
        $this->mostrarVentaProductos = false;
        $this->mostrarVentaTotales = false;
        $this->mostrarGastos = false;
        $this->mostrarBusquedaPersonalizada = false;
        $this->payments = false;
    }


    public function mostrarVentaTotal()
    {
        $this->mostrarVentaProductos = false;
        $this->mostrarVentaServicios = false;
        $this->mostrarVentaTotales = true;
        $this->mostrarGastos = false;
        $this->mostrarBusquedaPersonalizada = false;
        $this->payments = false;
    }


    public function limpiarEntorno()
    {
        $this->mostrarVentaProductos = false;
        $this->mostrarGastos = false;
        $this->mostrarBusquedaPersonalizada = false;
        $this->mostrarVentaServicios = false;
        $this->mostrarVentaTotales = false;
        $this->payments = false;
    }

    public function gastoDelDia()
    {
        $gastos = Gasto::whereFecha($this->fecha_gasto)->get();
        $this->gasto_dia = $gastos->sum('monto');
    }

    public function busquedaPersonalizada()
    {
        $this->mostrarVentaProductos = false;
        $this->mostrarVentaServicios = false;
        $this->mostrarVentaTotales = false;
        $this->mostrarGastos = false;
        $this->mostrarBusquedaPersonalizada = true;
        $this->payments = false;
    }



    public function cierreDelDia()
    {
      $ventas = Sale::whereFecha($this->fecha)->get();

      $this->cierre = $ventas->sum('totalPagado');
    }

    public function cierreEfectivo()
    {
        $ventasEfectivo = Sale::whereFecha($this->fecha_efectivo)->get();

          $this->cierre_efectivo = $ventasEfectivo->where('metodoPago', 'Efectivo')->sum('totalPagado');
    }

    public function cierreTransferencia()
    {
        $ventasTransferencia = Sale::whereFecha($this->fecha_transferencia)->get();
        $this->cierre_transferencia = $ventasTransferencia->where('metodoPago', 'Transferencia Bancaria')->sum('totalPagado');
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
      $totalVentasCustom = Sale::whereBetween('fecha', [$this->fecha_inicio, $this->fecha_fin ])->sum('totalPagado');
      $totalVentasFormateado = number_format($totalVentasCustom, 2, '.', ',');
      $this->custom_date = $totalVentasFormateado;
   }

   public function show_credits_payments()
   {
        $this->payments = true;
        $this->mostrarVentaProductos = false;
        $this->mostrarVentaServicios = false;
        $this->mostrarVentaTotales = false;
        $this->mostrarGastos = false;
        $this->mostrarBusquedaPersonalizada = false;
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
