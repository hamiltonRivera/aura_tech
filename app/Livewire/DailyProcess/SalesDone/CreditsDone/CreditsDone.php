<?php

namespace App\Livewire\DailyProcess\SalesDone\CreditsDone;
use App\Models\CreditPayment;
use App\Models\CreditSale;
use App\Models\HistorialFactura;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use RealRashid\SweetAlert\Facades\Alert;
class CreditsDone extends Component
{
    use WithPagination;

    public $search = '';
    public $showPaymentModal = false;
    public $selectedSaleId;
    public $selectedSaleClient = '';
    public $selectedSaleVoucher;
    public $selectedSaleBalance = 0;
    public $payment_date;
    public $amount_paid;
    public $observations = '';
    public $payment_method = 'Efectivo';
    public $change_given = 0;
    public $amount_received;

    public function mount()
    {
        $this->payment_date = now()->format('Y-m-d');
    }

    protected function rules()
    {
        return [
            'payment_date' => 'required|date',
            'amount_paid' => ['required', 'numeric', 'min:0.01', 'max:' . max((float) $this->selectedSaleBalance, 0)],
            'payment_method' => 'required|string|max:100',
            'amount_received' => $this->payment_method === 'Transferencia'
                ? 'nullable|numeric|min:0'
                : 'required|numeric|min:0.01',
            'observations' => 'nullable|string|max:255',
        ];
    }

    public function updatedAmountPaid($value)
    {
        if ($this->payment_method === 'Transferencia') {
            $this->amount_received = $value;
            $this->change_given = 0;
            return;
        }

        if (!is_numeric($this->amount_received)) {
            $this->amount_received = $value;
        }
        $this->calculateChange();
    }
    public function updatedPaymentMethod($value)
    {
        if ($value === 'Transferencia') {
            $this->amount_received = $this->amount_paid;
            $this->change_given = 0;
            return;
        }

        $this->calculateChange();
    }

    public function updatedAmountReceived()
    {
        if ($this->payment_method === 'Transferencia') {
            $this->amount_received = $this->amount_paid;
            $this->change_given = 0;
            return;
        }
        $this->calculateChange();
    }

    public function openPaymentModal($saleId)
    {
        $sale = CreditSale::with('client')->findOrFail($saleId);
        if (strtolower((string) $sale->status) === 'cancelado' || (float) $sale->outstanding_balance <= 0) {
            session()->flash('payment_error', 'Este crédito ya no tiene saldo pendiente.');
            return;
        }

        $this->selectedSaleId = $sale->id;
        $this->selectedSaleClient = $sale->client->nombreApellido;
        $this->selectedSaleVoucher = $sale->voucher_number;
        $this->selectedSaleBalance = (float) $sale->outstanding_balance;
        $this->payment_date = now()->format('Y-m-d');
        $this->amount_paid = null;
        $this->amount_received = null;
        $this->change_given = 0;
        $this->observations = '';
        $this->payment_method = 'Efectivo';
        $this->resetValidation();
        $this->showPaymentModal = true;
    }

    public function closePaymentModal()
    {
        $this->showPaymentModal = false;
        $this->resetPaymentForm();
    }

    protected function resetPaymentForm()
    {
        $this->selectedSaleId = null;
        $this->selectedSaleClient = '';
        $this->selectedSaleVoucher = null;
        $this->selectedSaleBalance = 0;
        $this->payment_date = now()->format('Y-m-d');
        $this->amount_paid = null;
        $this->amount_received = null;
        $this->change_given = 0;
        $this->observations = '';
        $this->payment_method = 'Efectivo';
        $this->resetValidation();
    }

    public function savePayment()
    {
        if (!$this->selectedSaleId) {
            return;
        }
        if (!Setting::first()) {
            $this->addError('amount_paid', 'No existe configuración de factura consecutiva.');
            return;
        }

        $sale = CreditSale::findOrFail($this->selectedSaleId);
        $this->selectedSaleBalance = (float) $sale->outstanding_balance;

        if (strtolower((string) $sale->status) === 'cancelado' || (float) $sale->outstanding_balance <= 0) {
            $this->addError('amount_paid', 'Este crédito ya está cancelado y no admite más abonos.');
            return;
        }

        $validated = $this->validate();

        $amountPaid = round((float) $validated['amount_paid'], 2);
        $amountReceived = $validated['payment_method'] === 'Transferencia'
            ? $amountPaid
            : round((float) $validated['amount_received'], 2);

        if ($amountPaid > (float) $sale->outstanding_balance) {
            $this->addError('amount_paid', 'El abono no puede ser mayor al saldo pendiente.');
            return;
        }
        if ($validated['payment_method'] !== 'Transferencia' && $amountReceived < $amountPaid) {
            $this->addError('amount_received', 'El monto recibido debe ser mayor o igual al abono.');
            return;
        }

        $changeGiven = $validated['payment_method'] === 'Transferencia'
            ? 0
            : round($amountReceived - $amountPaid, 2);
        $newBalance = max(0, round((float) $sale->outstanding_balance - $amountPaid, 2));
        $newInvoiceNumber = null;

        DB::transaction(function () use ($sale, $validated, $amountPaid, $amountReceived, $changeGiven, $newBalance, &$newInvoiceNumber) {
            $setting = Setting::lockForUpdate()->first();
            $newInvoiceNumber = (int) $setting->consecutivo + 1;
            CreditPayment::create([
                'credit_sale_id' => $sale->id,
                'payment_date' => $validated['payment_date'],
                'amount_paid' => $amountPaid,
                'observations' => $validated['observations'] ?? null,
                'payment_method' => $validated['payment_method'],
                'change_given' => $changeGiven,
                'amount_received' => $amountReceived,
            ]);
            HistorialFactura::create([
                'numFactura' => $newInvoiceNumber,
                'fecha' => $validated['payment_date'],
                'monto' => $amountPaid,
                'descripcion' => 'abono a crédito',
                'client_id' => $sale->client_id,
                'user_id' => auth()->user()->id,
                'metodoPago' => $validated['payment_method'],
            ]);

            $setting->consecutivo = $newInvoiceNumber;
            $setting->save();

            $sale->outstanding_balance = $newBalance;
            $sale->status = $newBalance <= 0 ? 'cancelado' : 'Activo';
            $sale->save();
        });

        $this->showPaymentModal = false;
        $this->resetPaymentForm();
        Alert::success('Pago registrado', 'El pago se ha registrado correctamente.');
        $this->refresh();
    }

    protected function calculateChange()
    {
        if ($this->payment_method === 'Transferencia') {
            $this->change_given = 0;
            return;
        }
        if (!is_numeric($this->amount_paid) || !is_numeric($this->amount_received)) {
            $this->change_given = 0;
            return;
        }

        $difference = round((float) $this->amount_received - (float) $this->amount_paid, 2);
        $this->change_given = $difference > 0 ? $difference : 0;
    }
    public function render()
    {
        $sales = CreditSale::with('user', 'client')
            ->whereRelation('user', 'name', 'like', '%' . $this->search . '%')
            ->orWhereRelation('client', 'nombreApellido', 'like', '%' . $this->search . '%')
            ->orWhereAny(['date', 'voucher_number'], 'like', '%' . $this->search . '%')->paginate(10);
        return view('livewire.daily-process.sales-done.credits-done.credits-done', compact('sales'));
    }

    public function refresh()
    {
        return redirect('/private/credit_sales_done');
    }
}
