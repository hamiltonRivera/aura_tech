<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::controller(AdminController::class)->group(function(){
    Route::group(['middleware' => ['can:administrador']], function(){
      Route::get('userscontrol', 'userscontrol')->name('userscontrol');
      Route::get('download-backup/{filename}', 'downloadBackup')->name('admin.download-backup');
      Route::get('categories', 'categories')->name('categories');
      Route::get('providers', 'providers')->name('providers');
      Route::get('orders', 'orders')->name('orders');
      Route::get('settings', 'settings')->name('settings');
      Route::get('activity_log', 'activity_log')->name('activity_log');
      Route::get('voucherHistory', 'voucherHistory')->name('voucherHistory');
      Route::get('incomes_expenses', 'incomes_expenses')->name('incomes_expenses');
      Route::get('adminUser', 'adminUser')->name('adminUser');
      Route::get('cashierUser', 'cashierUser')->name('cashierUser');
      Route::get('categoryExport', 'categoryExport')->name('categoryExport');
      Route::get('ordersDone', 'ordersDone')->name('ordersDone');
      Route::get('detailOrders/{id}', 'detailOrders')->name('detailOrders');
      Route::get('discounts', 'discounts')->name('discounts');
      Route::get('resetPassword', 'resetPassword')->name('resetPassword');
      Route::get('backup', 'backup')->name('backup');
      Route::get('payroll', 'payroll')->name('payroll');
      Route::get('sales_to_cancel', 'sales_to_cancel')->name('sales_to_cancel');
      //panel mobile
      Route::get('admin_panel', 'admin_panel')->name('admin_panel');
    });
});
