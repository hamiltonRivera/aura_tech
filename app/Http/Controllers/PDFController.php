<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Models\Cambio;
use App\Models\Category;
use App\Models\Client;
use App\Models\Discount;
use App\Models\Gasto;
use App\Models\Product;
use App\Models\ProductSale;
use App\Models\User;
use Barryvdh\DomPDF\Facade\PdF;
use Livewire\WithPagination;

class PDFController extends Controller
{
    use WithPagination;

 public function exchange_rate()
 {
    $records = Cambio::all();
    $pdf = PDF::loadView('daily-process.PDFs.exchange_rate', compact('records'));
    return $pdf->stream('reporte.pdf');
 }

 public function categories()
 {
   $records = Category::all();
   $pdf = PDF::loadView('daily-process.PDFs.categories', compact('records'));
   return $pdf->stream('reporte.pdf');
 }

 public function clients()
 {
  $records = Client::all();
  $pdf = PDF::loadView('daily-process.PDFs.clients', compact('records'));
  return $pdf->stream('reporte.pdf');
 }

 public function discounts()
 {
   $records = Discount::all();
   $pdf= PDF::loadView('daily-process.PDFs.discounts', compact('records'));
   return $pdf->stream('reporte.pdf');
 }

 public function expenses()
 {
   $records = Gasto::all();
   $pdf = PDF::loadView('daily-process.PDFs.expenses', compact('records'));
   return $pdf->stream('reporte.pdf');
 }

 public function products()
 {
   $records = Product::with('category')->paginate(100);
   $pdf = PDF::loadView('daily-process.PDFs.products', compact('records'));
   return $pdf->stream('reporte.pdf');
 }

 public function products_most_sold()
 {
   $records = ProductSale::with('product')->paginate(100);
   $pdf = PDF::loadView('daily-process.PDFs.products_most_sold', compact('records'));
   return $pdf->stream('reporte.pdf');
 }

 public function users()
 {
   $records = User::all();
   $pdf = PDF::loadView('daily-process.PDFs.users', compact('records'));
   return $pdf->stream('reporte.pdf');
 }

 public function credits_record()
 {
   return view('daily-process.PDFs.credits');
 }

   public function credit_details_pdf($id)
   {
      $credit = \App\Models\CreditSale::with(['client', 'creditDetails.product', 'creditPayments'])->findOrFail($id);
      $pdf = \Barryvdh\DomPDF\Facade\PDF::loadView('daily-process.PDFs.credits_details', compact('credit'));
      return $pdf->stream('detalle_credito.pdf');
   }

public function proforma()
{
    $proformaData = // Obtienes los datos de la proforma usando el $id recibido;
    
    $pdf = PDF::loadView('daily-process.PDFs.proforma', compact('proformaData'));
    return $pdf->stream('proforma.pdf');
}
}
