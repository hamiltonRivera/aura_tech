<?php

namespace App\Livewire\DailyProcess\SalesDone;

use App\Models\Sale;
use App\Models\CreditPayment;
use Livewire\Component;

class SalesDoneByMonth extends Component
{

    public $jan, $feb, $march, $april, $may, $jun, $july, $agost, $sep, $oct, $nov, $dec;
    public $total, $selected_month_name;
    public $month_selected = false;
    public function render()
    {
        return view('livewire.daily-process.sales-done.sales-done-by-month');
    }

    public function show_january()
    {
        $this->month_selected = true;
        $this->jan = $this->getMonthlyIncome(now()->year, 1);
        $this->total = number_format($this->jan, 2, '.', ',');
        $this->selected_month_name = 'Enero';
    }

    public function show_febrary()
    {
        $this->month_selected = true;
        $this->feb = $this->getMonthlyIncome(now()->year, 2);
        $this->total = number_format($this->feb, 2, '.', ',');
        $this->selected_month_name = 'Febrero';
    }

    public function show_march()
    {
        $this->month_selected = true;
        $this->march = $this->getMonthlyIncome(now()->year, 3);
        $this->total = number_format($this->march, 2, '.', ',');
        $this->selected_month_name = 'Marzo';
    }

    public function show_april()
    {
        $this->month_selected = true;
        $this->april = $this->getMonthlyIncome(now()->year, 4);
        $this->total = number_format($this->april, 2, '.', ',');
        $this->selected_month_name = 'Abril';
    }

    public function show_may()
    {
        $this->month_selected = true;
        $this->may = $this->getMonthlyIncome(now()->year, 5);
        $this->total = number_format($this->may, 2, '.', ',');
        $this->selected_month_name = 'Mayo';
    }

    public function show_jun()
    {
        $this->month_selected = true;
        $this->jun = $this->getMonthlyIncome(now()->year, 6);
        $this->total = number_format($this->jun, 2, '.', ',');
        $this->selected_month_name = 'Junio';
    }

    public function show_jul()
    {
        $this->month_selected = true;
        $this->july = $this->getMonthlyIncome(now()->year, 7);
        $this->total = number_format($this->july, 2, '.', ',');
        $this->selected_month_name = 'Julio';
    }

    public function show_agost()
    {
        $this->month_selected = true;
        $this->agost = $this->getMonthlyIncome(now()->year, 8);
        $this->total = number_format($this->agost, 2, '.', ',');
        $this->selected_month_name = 'Agosto';
    }

    public function show_sept()
    {
        $this->month_selected = true;
        $this->sep = $this->getMonthlyIncome(now()->year, 9);
        $this->total = number_format($this->sep, 2, '.', ',');
        $this->selected_month_name = 'Septiembre';
    }

    public function show_oct()
    {
        $this->month_selected = true;
        $this->oct = $this->getMonthlyIncome(now()->year, 10);
        $this->total = number_format($this->oct, 2, '.', ',');
        $this->selected_month_name = 'Octubre';
    }

    public function show_nov()
    {
        $this->month_selected = true;
        $this->nov = $this->getMonthlyIncome(now()->year, 11);
        $this->total = number_format($this->nov, 2, '.', ',');
        $this->selected_month_name = 'Noviembre';
    }

    public function show_dec()
    {
        $this->month_selected = true;
        $this->dec = $this->getMonthlyIncome(now()->year, 12);
        $this->total = number_format($this->dec, 2, '.', ',');
        $this->selected_month_name = 'Diciembre';
    }

    public function show_total()
    {
        $this->month_selected = true;
        $this->total = $this->getYearlyIncome(now()->year);
        $this->total = number_format($this->total, 2, '.', ',');
        $this->selected_month_name = 'Total Anual';
    }

    public function clear()
    {
        $this->month_selected = false;
        $this->total = null;
        $this->selected_month_name = null;
    }

    //año 2025
    public function show_january_25()
    {
        $this->month_selected = true;
        $this->jan = $this->getMonthlyIncome(2025, 1);

        // Aquí ya lo formateas
        $this->total = number_format($this->jan, 2, '.', ',');

        $this->selected_month_name = 'Enero 2025';
    }

    public function show_febrary_25()
    {
        $this->month_selected = true;

        $this->feb = $this->getMonthlyIncome(2025, 2);

        // Aquí ya lo formateas
        $this->total = number_format($this->feb, 2, '.', ',');

        $this->selected_month_name = 'Febrero 2025';
    }

    public function show_march_25()
    {
        $this->month_selected = true;

        $this->march = $this->getMonthlyIncome(2025, 3);

        // Aquí ya lo formateas
        $this->total = number_format($this->march, 2, '.', ',');

        $this->selected_month_name = 'Marzo 2025';
    }

    public function show_april_25()
    {
        $this->month_selected = true;

        $this->april = $this->getMonthlyIncome(2025, 4);

        // Aquí ya lo formateas
        $this->total = number_format($this->april, 2, '.', ',');

        $this->selected_month_name = 'Abril 2025';
    }

    public function show_may_25()
    {
        $this->month_selected = true;

        $this->may = $this->getMonthlyIncome(2025, 5);

        // Aquí ya lo formateas
        $this->total = number_format($this->may, 2, '.', ',');

        $this->selected_month_name = 'Mayo 2025';
    }

    public function show_jun_25()
    {
        $this->month_selected = true;

        $this->jun = $this->getMonthlyIncome(2025, 6);

        // Aquí ya lo formateas
        $this->total = number_format($this->jun, 2, '.', ',');

        $this->selected_month_name = 'Junio 2025';
    }

    public function show_jul_25()
    {
        $this->month_selected = true;

        $this->july = $this->getMonthlyIncome(2025, 7);

        // Aquí ya lo formateas
        $this->total = number_format($this->july, 2, '.', ',');

        $this->selected_month_name = 'Julio 2025';
    }

    public function show_agost_25()
    {
        $this->month_selected = true;

        $this->agost = $this->getMonthlyIncome(2025, 8);

        // Aquí ya lo formateas
        $this->total = number_format($this->agost, 2, '.', ',');

        $this->selected_month_name = 'Agosto 2025';
    }

    public function show_sept_25()
    {
        $this->month_selected = true;

        $this->sep = $this->getMonthlyIncome(2025, 9);

        // Aquí ya lo formateas
        $this->total = number_format($this->sep, 2, '.', ',');

        $this->selected_month_name = 'Septiembre 2025';
    }

    public function show_oct_25()
    {
        $this->month_selected = true;

        $this->oct = $this->getMonthlyIncome(2025, 10);

        // Aquí ya lo formateas
        $this->total = number_format($this->oct, 2, '.', ',');

        $this->selected_month_name = 'Octubre 2025';
    }

    public function show_nov_25()
    {
        $this->month_selected = true;

        $this->nov = $this->getMonthlyIncome(2025, 11);

        // Aquí ya lo formateas
        $this->total = number_format($this->nov, 2, '.', ',');

        $this->selected_month_name = 'Noviembre 2025';
    }

    public function show_dec_25()
    {
        $this->month_selected = true;

        $this->dec = $this->getMonthlyIncome(2025, 12);

        // Aquí ya lo formateas
        $this->total = number_format($this->dec, 2, '.', ',');

        $this->selected_month_name = 'Diciembre 2025';
    }

    public function show_total_25()
    {
        $this->month_selected = true;
        $this->total = number_format($this->getYearlyIncome(2025), 2, '.', ',');
        $this->selected_month_name = 'Total Anual 2025';
    }

    protected function getMonthlyIncome(int $year, int $month): float
    {
        $salesIncome = Sale::whereYear('fecha', $year)
            ->whereMonth('fecha', $month)
            ->sum('totalPagado');
        $creditPaymentsIncome = CreditPayment::whereYear('payment_date', $year)
            ->whereMonth('payment_date', $month)
            ->sum('amount_paid');
        return $salesIncome + $creditPaymentsIncome;
    }

    protected function getYearlyIncome(int $year): float
    {
        $salesIncome = Sale::whereYear('fecha', $year)->sum('totalPagado');
        $creditPaymentsIncome = CreditPayment::whereYear('payment_date', $year)->sum('amount_paid');
        return $salesIncome + $creditPaymentsIncome;
    }
}
