<?php

use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Route;

Route::controller(PDFController::class)->group(function(){
 Route::group(['middleware' => ['can:procesos.diarios']],function(){
   Route::get('activities', 'activities')->name('activities');
   Route::get('exchange_rate', 'exchange_rate')->name('exchange_rate_report');
   Route::get('categories', 'categories')->name('categories_report');
   Route::get('clients', 'clients')->name('clients_report');
   Route::get('discounts', 'discounts')->name('discounts_report');
   Route::get('expenses', 'expenses')->name('expenses_report');
   Route::get('products', 'products')->name('products_report');
   Route::get('products_most_sold', 'products_most_sold')->name('products_most_sold_report');
   Route::get('users', 'users')->name('users_report');
   Route::get('credits', 'credits_record')->name('credits_report');
   Route::get('credits/details/{id}', 'credit_details_pdf')->name('credits_details_pdf');
   Route::get('/private/proforma/pdf', [PDFController::class, 'proforma'])->name('proforma.pdf');
 });
});
