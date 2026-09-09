<?php

use App\Http\Controllers\DailyProcessController;
use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Route;

Route::controller(DailyProcessController::class)->group(function(){
    Route::group(['middleware' => ['can:procesos.diarios']], function(){
  Route::get('products', 'products')->name('products');
  Route::get('products_in_stock', 'products_in_stock')->name('products_in_stock');
  Route::get('products_no_stock', 'products_no_stock')->name('products_no_stock');
  Route::get('clients', 'clients')->name('clients');
  Route::get('expenses', 'expenses')->name('expenses');
  Route::get('reports', 'reports')->name('reports');
  Route::get('exchange_rate', 'exchange_rate')->name('exchange_rate');
  Route::get('products_most_sold', 'products_most_sold')->name('products_most_sold');
  Route::get('sales', 'sales')->name('sales');
  Route::get('salesDone', 'salesDone')->name('salesDone');
  Route::get('detailItems/{id}', 'detailItems')->name('detailItems');
  Route::get('payments/{id}', 'payments')->name('payments');
  Route::get('detailItems_credit/{id}', 'detailItems_credit')->name('detailItems_credit');
  Route::get('reprint/{sale}', 'reprint')->name('reprint');
  Route::get('reprint_credit/{sale}', 'reprint_credit')->name('reprint_credit');
  Route::get('salesByMonth', 'sales_done_by_month')->name('sales_done_by_month');
  Route::get('executive-dashboard', 'executive_dashboard')->name('executive.dashboard');
  Route::get('credit-sales', 'credit_sales')->name('credit_sales');
  Route::get('credit_sales_done', 'credit_sales_done')->name('credit_sales_done');
  Route::get('catalog', 'catalog')->name('catalog');
  Route::get('proforma', 'proforma')->name('proforma');
  Route::get('/proforma_printed', [PDFController::class, 'proforma'])->name('proforma.pdf');
  Route::get('combos', 'combos')->name('combos');
  Route::get('combos_edit_update', 'combos_e_u_d')->name('combos_e_u_d');
  //vista movil
  Route::get('processes', 'processes')->name('processes');
  });
});

