<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\CategoryExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Order;
class AdminController extends Controller
{
    public function userscontrol()
    {
        return view('admin.users-control.users-control');
    }

    public function categories()
    {
        return view('admin.categories');
    }

    public function providers()
    {
        return view('admin.providers');
    }

    public function orders()
    {
        return view('admin.orders');
    }

    public function incomes_expenses()
    {
        return view('admin.incomes_expenses');
    }

    public function voucherHistory()
    {
        return view('admin.voucherHistory');
    }

    public function activity_log()
    {
        return view('admin.activityLogs');
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function adminUser()
    {
        return view('admin.users-control.admin-user');
    }

    public function cashierUser()
    {
        return view('admin.users-control.cashier-user');
    }

    public function categoryExport()
    {
        return Excel::download(new CategoryExport, 'categories.xlsx');
    }

    public function ordersDone()
    {
        return view('admin.OrdersDone');
    }

    public function detailOrders(Order $id)
    {
      $items = $id->detailOrders()->paginate(15);
      return view('admin.detailOrders', compact('id', 'items'));
    }

    public function discounts()
    {
        return view('admin.discounts');
    }

    public function resetPassword()
    {
      return view('admin.users-control.reset-password');
    }

    public function backup()
    {
        return view('admin.backup');
    }

    /**
     * Descargar un archivo de backup por nombre
     */
    public function downloadBackup($filename)
    {
        $path = storage_path('app/Laravel/' . $filename);
        if (!file_exists($path)) {
            abort(404, 'Backup no encontrado');
        }
        return response()->download($path);
    }

    public function admin_panel()
    {
        return view('layouts.mobile_view.admin_panel');
    }

    public function payroll()
    {
        return view('admin.payroll');
    }
}
