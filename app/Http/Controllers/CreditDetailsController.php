<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CreditSale;
use Barryvdh\DomPDF\Facade\PDF;

class CreditDetailsController extends Controller
{
    // ...existing code...

    public function credit_details_pdf($id)
    {
        $credit = CreditSale::with(['client', 'creditDetails.product', 'creditPayments'])->findOrFail($id);
        $pdf = PDF::loadView('daily-process.PDFs.credits_details', compact('credit'));
        return $pdf->stream('detalle_credito.pdf');
    }
}
