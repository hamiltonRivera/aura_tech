<?php

use Livewire\Component;
use App\Models\User;
use App\Models\ActivityLog;
use App\Models\Payroll;
use RealRashid\SweetAlert\Facades\Alert;
use Livewire\WithPagination;

new class extends Component {
     use WithPagination;

     public $search_user = '';
     public $search = '';
     
     // 1. Agregamos las variables nuevas
     public $user_id = ''; 
     public $start_date, $end_date, $monthly_salary, $quarter_salary, $daily_salary;
     public $total_payment_holly_days = 0, $total_payment_quarter = 0, $total_payment_monthly = 0;
     public $holly_days = 0;
     public $selected_id;

     // Variables para impuestos
     public $apply_deductions = 'no'; 
     public $inss_deduction = 0;
     public $ir_deduction = 0;
     public $net_payment_quarter = 0;

     public function with(): array
    {
        return [
            'users' => User::orderBy('id','asc')
            ->where('name', 'like', '%' . $this->search_user . '%')
            ->orWhere('email', 'like', '%' . $this->search_user . '%')->get(),
        ];
    }

    public function refresh()
    {
        return redirect('/private/admin/payroll');
    }

    // 2. Esta es la función mágica que jala el salario de MySQL
    public function updatedUserId($value)
    {
        if (!empty($value)) {
            $empleado = User::find($value);
            $this->monthly_salary = $empleado ? $empleado->salary : null;
        } else {
            $this->monthly_salary = null;
        }
        $this->calculatePayroll();
    }

    public function updatedHollyDays() { $this->calculatePayroll(); }
    public function updatedApplyDeductions() { $this->calculatePayroll(); }

    // 3. Cálculos completos con INSS e IR
    public function calculatePayroll()
    {
        if (empty($this->monthly_salary) || $this->monthly_salary <= 0) {
            $this->quarter_salary = $this->daily_salary = $this->total_payment_holly_days = null;
            $this->total_payment_monthly = $this->total_payment_quarter = null;
            $this->inss_deduction = $this->ir_deduction = $this->net_payment_quarter = null;
            return;
        }

        // Salarios
        $this->quarter_salary = round($this->monthly_salary / 2, 2);
        $this->daily_salary = round($this->monthly_salary / 30, 2);

        // Feriados
        $dias = (is_numeric($this->holly_days) && $this->holly_days > 0) ? $this->holly_days : 0;
        $this->total_payment_holly_days = round(($this->daily_salary * 2) * $dias, 2);

        // Totales Brutos
        $this->total_payment_monthly = $this->monthly_salary + $this->total_payment_holly_days;
        $this->total_payment_quarter = $this->quarter_salary + $this->total_payment_holly_days;

        // Deducciones (Solo si el radio button está en "si")
        if ($this->apply_deductions === 'si') {
            $this->inss_deduction = round($this->total_payment_quarter * 0.07, 2);
            $this->ir_deduction = $this->calculateIRQuincenal($this->monthly_salary);
        } else {
            $this->inss_deduction = 0;
            $this->ir_deduction = 0;
        }

        // Neto
        $this->net_payment_quarter = round($this->total_payment_quarter - $this->inss_deduction - $this->ir_deduction, 2);
    }

    // Tabla del IR de Nicaragua
    private function calculateIRQuincenal($salarioMensual)
    {
        $inssMensual = $salarioMensual * 0.07;
        $salarioNetoMensual = $salarioMensual - $inssMensual;
        $salarioAnual = $salarioNetoMensual * 12;
        $irAnual = 0;

        if ($salarioAnual > 100000 && $salarioAnual <= 200000) {
            $irAnual = (($salarioAnual - 100000) * 0.15);
        } elseif ($salarioAnual > 200000 && $salarioAnual <= 350000) {
            $irAnual = (($salarioAnual - 200000) * 0.20) + 15000;
        } elseif ($salarioAnual > 350000 && $salarioAnual <= 500000) {
            $irAnual = (($salarioAnual - 350000) * 0.25) + 45000;
        } elseif ($salarioAnual > 500000) {
            $irAnual = (($salarioAnual - 500000) * 0.30) + 82500;
        }

        return round(($irAnual / 12) / 2, 2);
    }

    public function store()
    {
        $this->validate([
          'user_id' => 'required',
          'start_date' => 'required|date',
          'end_date' => 'required|date',
          'monthly_salary' => 'required|numeric',
          'quarter_salary' => 'required|numeric',
          'daily_salary' => 'required|numeric',
          'holly_days' => 'required|numeric',
          'total_payment_holly_days' => 'required|numeric',
          'total_payment_monthly' => 'required|numeric',
          'total_payment_quarter' => 'required|numeric',
          'inss_deduction' => 'required|numeric',
          'ir_deduction' => 'required|numeric',
          'net_payment_quarter' => 'required|numeric',
          'apply_deductions' => 'nullable|string'
        ]);

        $payroll = new Payroll();
        $payroll->user_id = $this->user_id;
        $payroll->start_date = $this->start_date;
        $payroll->end_date = $this->end_date;
        $payroll->monthly_salary = $this->monthly_salary;
        $payroll->quarter_salary = $this->quarter_salary;
        $payroll->daily_salary = $this->daily_salary;
        $payroll->holly_days = $this->holly_days;
        $payroll->total_payment_holly_days = $this->total_payment_holly_days;
        $payroll->total_payment_monthly = $this->total_payment_monthly;
        $payroll->total_payment_quarter = $this->total_payment_quarter;
        $payroll->inss_deduction = $this->inss_deduction;
        $payroll->ir_deduction = $this->ir_deduction;
        $payroll->net_payment_quarter = $this->net_payment_quarter;
        $payroll->apply_deductions = $this->apply_deductions;
        $payroll->save();

        $newActivitie = new ActivityLog();
        $newActivitie->user_id = auth()->user()->id;
        $newActivitie->activity = "Nuevo Registro - Planilla";
        $newActivitie->detail = $payroll->user->name;
        $newActivitie->save();
        Alert::success('Registro de planilla', ' registro guardado exitosamente');
        $this->refresh();

    }
};
?>

<div>
    <div class="lg:grid grid-cols-4 sm:grid-col-1">
        {{-- primer columna --}}
        <div>
          @include('components.admin.payrolls.columns.first')
        </div>

        {{-- segunda columna --}}
        <div>
          @include('components.admin.payrolls.columns.second')
        </div>

        {{-- tercera columna --}}
        <div>
          @include('components.admin.payrolls.columns.third')
        </div>

        {{-- cuarta columna --}}
        <div>
          @include('components.admin.payrolls.columns.fourth')
        </div>
    </div>

    <div class="mb-3">
        @include('components.admin.payrolls.search')
    </div>

    <div>
      @include('components.admin.payrolls.table')
    </div>    
</div>
