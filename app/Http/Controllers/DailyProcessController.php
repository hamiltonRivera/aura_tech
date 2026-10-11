<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\CreditSale;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
class DailyProcessController extends Controller
{
    public function products()
    {
        return view('daily-process.products');
    }

    public function clients()
    {
        return view('daily-process.clients');
    }

    public function expenses()
    {
        return view('daily-process.expenses');
    }

    public function reports()
    {
        return view('daily-process.reports');
    }

    public function exchange_rate()
    {
        return view('daily-process.exchange_rate');
    }

    public function products_most_sold()
    {
        return view('daily-process.products_most_sold');
    }

    public function sales()
    {
        return view('daily-process.sales');
    }

    public function salesDone()
    {
        return view('daily-process.salesDone.salesDone');
    }


    public function detailItems(Sale $id)
    {
        $items = $id->detailSales()->paginate(15);
        return view('daily-process.salesDone.detailItems', compact('id', 'items'));
    }

    public function detailItems_credit(CreditSale $id)
    {
      $items = $id->creditDetails()->paginate(15);
      return view('daily-process.salesDone.detailItems_credit', compact('id', 'items'));
    }

    public function payments(CreditSale $id)
    {
        $payments = $id->creditPayments()->paginate(15);
        return view('daily-process.salesDone.payments', compact('id', 'payments'));
    }

    public function catalog()
    {
        return view('daily-process.catalog');
    }

    public function reprint_credit(CreditSale $sale)
    {
        $impresora = "//localhost/POS-58";
        $connector = new FilePrintConnector($impresora);
        $printer = new Printer($connector);
        //datos del negocio
        //justificado al centro
        $printer->setjustification(Printer::JUSTIFY_CENTER);
        $printer->text("Eli Makeup Store\n\n");
        $printer->text("Eli Makeup Store\n\n");
        //$img = EscposImage::load(base_path("main.png"));
        //$printer -> graphics($img);

        // $image = new Imagick('public/main.jpg');

        // $image->cropImage(190, 300, 350, 565);
        // $image->resizeImage(256, 350, Imagick::FILTER_CATROM, 0);

        // header("Content-Type: image/png");
        // $printer->text($image->getImageBlob());

        $printer->text("Dirección: Matagalpa, de gasolinera gas central 90mtrs al oeste, contigo a restaurante el" . "\n");
        $printer->text("taquero" . "\n");
        $printer->text("Teléfono: 8841-6715 / 8703-2918" . "\n");
        //$img = EscposImage::load('C:\proyectosLaravel\eliStore-vite\public\imagenes\main.jpg', false);
        //$printer -> bitImage($img);
        //$printer -> bitImageColumnFormat($img);
        $printer -> cut();
        $printer->text("===============================\n");

        //justificar a la derecha
        $printer->setjustification(Printer::JUSTIFY_LEFT);
        //$printer->text("Fecha: ". $newventa->fecha . "\n");
        $printer->text("Fecha: " . Carbon::parse($sale->created_at) . "\n");
        $printer->text("No de factura: " . $sale->numFactura . "\n");
        $printer->text("===============================\n");

         //justificado al centro
         $printer->setjustification(Printer::JUSTIFY_CENTER);
         $printer->text("==================\n");
         $printer->text("Detalle de la venta\n");
         $printer->text("==================\n\n");

         //justificado a la izquierda
         $printer->setjustification(Printer::JUSTIFY_LEFT);
         $fonts = array(Printer::FONT_A, Printer::FONT_B, Printer::FONT_C);
         $printer->text("Producto|" . "Precio|" . "Cantidad|" . "Total" . "\n");
         $printer->text("------------------------------"  . "\n");
         foreach($sale->creditDetails as $detailSale)
         {
            $printer->setFont($fonts[2]);
            $printer->text( "* " . $detailSale->product->descripcion . " |" . $detailSale->precio . "|" .  " * " . $detailSale->cantidad . " = " . " " .
             $detailSale->total . "\n");

        }

         $printer->text("=======================\n");
         $printer->text("Total: " . $sale->total_debt . "\n");
         $printer->text("Atendido por: " . $sale->user->name . "\n");
         $printer->text("Nota: No se aceptan devoluciones" . "\n\n\n\n");
         $printer ->cut();
         $printer ->close();
         Alert::success('Reimpresión', 'Reimpresión realizada exitosamente');
         return back();
    }
    public function reprint(Sale $sale)
    {
        $impresora = "//localhost/POS-58";
        $connector = new FilePrintConnector($impresora);
        $printer = new Printer($connector);
        //datos del negocio
        //justificado al centro
        $printer->setjustification(Printer::JUSTIFY_CENTER);
        $printer->text("Eli Makeup Store\n\n");
        $printer->text("Eli Makeup Store\n\n");
        //$img = EscposImage::load(base_path("main.png"));
        //$printer -> graphics($img);

        // $image = new Imagick('public/main.jpg');

        // $image->cropImage(190, 300, 350, 565);
        // $image->resizeImage(256, 350, Imagick::FILTER_CATROM, 0);

        // header("Content-Type: image/png");
        // $printer->text($image->getImageBlob());

        $printer->text("Dirección: Matagalpa, de gasolinera gas central 90mtrs al oeste, contigo a restaurante el" . "\n");
        $printer->text("taquero" . "\n");
        $printer->text("Teléfono: 8841-6715 / 8703-2918" . "\n");
        //$img = EscposImage::load('C:\proyectosLaravel\eliStore-vite\public\imagenes\main.jpg', false);
        //$printer -> bitImage($img);
        //$printer -> bitImageColumnFormat($img);
        $printer -> cut();
        $printer->text("===============================\n");

        //justificar a la derecha
        $printer->setjustification(Printer::JUSTIFY_LEFT);
        //$printer->text("Fecha: ". $newventa->fecha . "\n");
        $printer->text("Fecha: " . Carbon::parse($sale->created_at) . "\n");
        $printer->text("No de factura: " . $sale->numFactura . "\n");
        $printer->text("===============================\n");

         //justificado al centro
         $printer->setjustification(Printer::JUSTIFY_CENTER);
         $printer->text("==================\n");
         $printer->text("Detalle de la venta\n");
         $printer->text("==================\n\n");

         //justificado a la izquierda
         $printer->setjustification(Printer::JUSTIFY_LEFT);
         $fonts = array(Printer::FONT_A, Printer::FONT_B, Printer::FONT_C);
         $printer->text("Producto|" . "Precio|" . "Cantidad|" . "Total" . "\n");
         $printer->text("------------------------------"  . "\n");
         foreach($sale->detailSales as $detailSale)
         {
            $printer->setFont($fonts[2]);
            $printer->text( "* " . $detailSale->product->descripcion . " |" . $detailSale->precio . "|" .  " * " . $detailSale->cantidad . " = " . " " .
             $detailSale->total . "\n");

        }

         $printer->text("=======================\n");
         $printer->text("Total: " . $sale->totalPagado . "\n");
         $printer->text("Cambio: " . $sale->cambio . "\n");
         $printer->text("Atendido por: " . $sale->user->name . "\n");
         $printer->text("Nota: No se aceptan devoluciones" . "\n\n\n\n");
         $printer ->cut();
         $printer ->close();
         Alert::success('Reimpresión', 'Reimpresión realizada exitosamente');
         return back();
    }

    public function products_in_stock()
    {
      return view('daily-process.products_in_stock');
    }

    public function products_no_stock()
    {
      return view('daily-process.products_no_stock');
    }

    public function sales_done_by_month()
    {
        return view('daily-process.salesDone.salesByMonth');
    }

    public function executive_dashboard()
    {
        return view('executive-dashboard');
    }

    public function credit_sales()
    {
        return view('daily-process.credit_sales');
    }

    public function credit_sales_done()
    {
        return view('daily-process.salesDone.credit-sales-done');
    }

    public function proforma()
    {
        return view('daily-process.proforma');
    }

    public function combos()
    {
        return view('daily-process.combos');
    }

    public function combos_e_u_d()
    {
        return view('daily-process.combos_e_u_d');
    }

    public function processes()
    {
        return view('layouts.mobile_view.processes');
    }

    public function cash_reconciliation()
    {
        return view('daily-process.cash_reconciliation');
    }

    public function cash_audit()
    {
        return view('daily-process.cash_audit');
    }
    
    public function audit()
    {
        return view('daily-process.audit');
    }
}
