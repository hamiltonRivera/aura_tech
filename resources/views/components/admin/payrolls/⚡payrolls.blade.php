<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\User;
use App\Models\ActivityLog;
use App\Models\Payroll;
use App\Models\Gasto;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $search_user = '';
    public $search = '';
    public $last_day_off_taken;

    // 1. Agregamos las variables de identidad, fechas y adelantos
    public $user_id = '';
    public $start_date,
        $end_date,
        $monthly_salary,
        $quarter_salary,
        $daily_salary,
        $salary_advance = 0,
        $last_advance_date = null;
    public $total_payment_holly_days = 0,
        $total_payment_quarter = 0,
        $total_payment_monthly = 0;
    public $holly_days = 0;
    public $selected_id, $available_days_off, $total_days_off, $days_off_taken, $hire_date;

    // Variables para impuestos
    public $apply_deductions = 'no';
    public $inss_deduction = 0;
    public $ir_deduction = 0;
    public $net_payment_quarter = 0;

    public function with(): array
    {
        return [
            'users' => User::orderBy('id', 'asc')
                ->where('name', 'like', '%' . $this->search_user . '%')
                ->orWhere('email', 'like', '%' . $this->search_user . '%')
                ->get(),

            'payrolls' => Payroll::with('user')
                ->whereRelation('user', 'name', 'like', '%' . $this->search . '%')
                ->paginate(10),
        ];
    }

    public function updatedHireDate()
    {
        $this->calculateVacations();
    }

    public function calculateVacations()
    {
        if (!empty($this->hire_date)) {
            $fechaInicio = Carbon::parse($this->hire_date);
            $fechaActual = Carbon::now();

            if ($fechaInicio->lessThanOrEqualTo($fechaActual)) {
                $mesesTrabajados = $fechaInicio->floatDiffInMonths($fechaActual);
                $this->total_days_off = round($mesesTrabajados * 2.5, 2);
            } else {
                $this->total_days_off = 0;
            }
        } else {
            if (!empty($this->user_id)) {
                $empleado = User::find($this->user_id);
                $this->total_days_off = $empleado ? (float) ($empleado->total_days_off ?? 0) : 0;
            } else {
                $this->total_days_off = 0;
            }
        }

        $tomadas = (float) ($this->days_off_taken ?? 0);
        $this->available_days_off = round($this->total_days_off - $tomadas, 2);
    }

    public function refresh()
    {
        return redirect('/private/admin/payroll');
    }

    // 2. Función reactiva que jala todos los datos del modelo al seleccionar un empleado
    public function updatedUserId($value)
    {
        if (!empty($value)) {
            $empleado = User::find($value);

            if ($empleado) {
                $this->monthly_salary = $empleado->salary ?? null;
                $this->hire_date = $empleado->hire_date ? Carbon::parse($empleado->hire_date)->format('Y-m-d') : null;
                $this->days_off_taken = $empleado->days_off_taken ?? 0;

                // Carga de adelantos pendientes
                $this->salary_advance = $empleado->salary_advance ?? 0;
                $this->last_advance_date = !empty($empleado->last_advance_date) ? Carbon::parse($empleado->last_advance_date)->format('Y-m-d') : null;

                $this->calculateVacations();
            }
        } else {
            $this->reset(['monthly_salary', 'hire_date', 'total_days_off', 'days_off_taken', 'available_days_off', 'quarter_salary', 'daily_salary', 'total_payment_quarter', 'net_payment_quarter', 'salary_advance', 'last_advance_date']);
        }

        $this->calculatePayroll();
    }

    public function updatedDaysOffTaken($value)
    {
        $tomadas = (float) ($value ?? 0);
        $this->available_days_off = round($this->total_days_off - $tomadas, 2);
    }

    public function updatedHollyDays()
    {
        $this->calculatePayroll();
    }

    public function updatedApplyDeductions()
    {
        $this->calculatePayroll();
    }

    public function updatedMonthlySalary()
    {
        $this->calculatePayroll();
    }

    // Recálculo reactivo si modifican el input del adelanto a mano
    public function updatedSalaryAdvance()
    {
        $this->calculatePayroll();
    }

    // 3. Cálculos completos con INSS, IR y Adelantos
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
        $dias = is_numeric($this->holly_days) && $this->holly_days > 0 ? $this->holly_days : 0;
        $this->total_payment_holly_days = round($this->daily_salary * 2 * $dias, 2);

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

        // Recuperar y restar el adelanto del neto
        $adelanto = is_numeric($this->salary_advance) ? (float) $this->salary_advance : 0;

        // Neto descontando impuestos y el adelanto
        $this->net_payment_quarter = round($this->total_payment_quarter - $this->inss_deduction - $this->ir_deduction - $adelanto, 2);

        // Evitamos montos negativos
        if ($this->net_payment_quarter < 0) {
            $this->net_payment_quarter = 0;
        }
    }

    // Tabla del IR de Nicaragua
    private function calculateIRQuincenal($salarioMensual)
    {
        $inssMensual = $salarioMensual * 0.07;
        $salarioNetoMensual = $salarioMensual - $inssMensual;
        $salarioAnual = $salarioNetoMensual * 12;
        $irAnual = 0;

        if ($salarioAnual > 100000 && $salarioAnual <= 200000) {
            $irAnual = ($salarioAnual - 100000) * 0.15;
        } elseif ($salarioAnual > 200000 && $salarioAnual <= 350000) {
            $irAnual = ($salarioAnual - 200000) * 0.2 + 15000;
        } elseif ($salarioAnual > 350000 && $salarioAnual <= 500000) {
            $irAnual = ($salarioAnual - 350000) * 0.25 + 45000;
        } elseif ($salarioAnual > 500000) {
            $irAnual = ($salarioAnual - 500000) * 0.3 + 82500;
        }

        return round($irAnual / 12 / 2, 2);
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
            'apply_deductions' => 'nullable|string',
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

        // ACTUALIZAMOS EL MODELO USER
        $empleado = User::find($this->user_id);
        if ($empleado) {
            $empleado->total_days_off = $this->total_days_off;
            $empleado->days_off_taken = $this->days_off_taken;
            $empleado->available_days_off = $this->available_days_off;

            // Regresamos el adelanto a 0 al guardar la planilla
            $empleado->salary_advance = 0;
            $empleado->last_advance_date = Carbon::now()->format('Y-m-d');

            $empleado->save();
        }

        $expenses = new Gasto();
        $expenses->descripcion = 'Pago de planilla - ' . $payroll->user->name;
        $expenses->fecha = today();
        $expenses->monto = $payroll->total_payment_quarter;
        $expenses->tipo_gasto = 'Operacionales';
        $expenses->save();

        $newActivitie = new ActivityLog();
        $newActivitie->user_id = auth()->user()->id;
        $newActivitie->activity = 'Nuevo Registro - Pago de Planilla';
        $newActivitie->detail = $payroll->user->name;
        $newActivitie->save();

        $paycheckData = [
            'payroll_id' => $payroll->id,
            'empleado_nombre' => $payroll->user->name,
            'start_date' => $payroll->start_date,
            'end_date' => $payroll->end_date,
            'monthly_salary' => $payroll->monthly_salary,
            'total_payment_quarter' => $payroll->total_payment_quarter,
            'inss_deduction' => $payroll->inss_deduction,
            'ir_deduction' => $payroll->ir_deduction,
            'net_payment_quarter' => $payroll->net_payment_quarter,
            // Guardamos el adelanto para que salga en el PDF
            'adelanto_descontado' => is_numeric($this->salary_advance) ? $this->salary_advance : 0,
        ];

        session()->put('paycheck', $paycheckData);
        Alert::success('Registro de planilla', 'Registro guardado exitosamente');

        $this->dispatch('abrir-pdf', url: route('paycheck.pdf'));
        $this->refresh();
    }

    public function edit($id)
    {
        $record = Payroll::with('user')->findOrFail($id);

        $this->selected_id = $id;
        $this->user_id = $record->user_id;

        $this->start_date = $record->start_date ? Carbon::parse($record->start_date)->format('Y-m-d') : null;
        $this->end_date = $record->end_date ? Carbon::parse($record->end_date)->format('Y-m-d') : null;

        $this->monthly_salary = $record->monthly_salary;
        $this->quarter_salary = $record->quarter_salary;
        $this->daily_salary = $record->daily_salary;

        $this->holly_days = $record->holly_days;
        $this->total_payment_holly_days = $record->total_payment_holly_days;

        $this->total_payment_monthly = $record->total_payment_monthly;
        $this->total_payment_quarter = $record->total_payment_quarter;
        $this->apply_deductions = $record->apply_deductions;
        $this->inss_deduction = $record->inss_deduction;
        $this->ir_deduction = $record->ir_deduction;
        $this->net_payment_quarter = $record->net_payment_quarter;

        // Cargar los datos de vacaciones y adelantos al editar
        if ($record->user) {
            $this->hire_date = $record->user->hire_date ? Carbon::parse($record->user->hire_date)->format('Y-m-d') : null;
            $this->total_days_off = $record->user->total_days_off ?? 0;
            $this->days_off_taken = $record->user->days_off_taken ?? 0;
            $this->available_days_off = $record->user->available_days_off ?? 0;
            $this->last_day_off_taken = $record->user->last_day_off_taken;

            $this->salary_advance = $record->user->salary_advance ?? 0;
            $this->last_advance_date = $record->user->last_advance_date;
        }
    }

    public function update()
    {
        $validate = $this->validate([
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
            'apply_deductions' => 'nullable|string',
        ]);

        if ($this->selected_id) {
            $record = Payroll::findOrFail($this->selected_id);
            $record->update($validate);

            $empleado = User::find($this->user_id);
            if ($empleado) {
                $empleado->salary = $this->monthly_salary;
                $empleado->hire_date = $this->hire_date;
                $empleado->last_day_off_taken = $this->last_day_off_taken;
                $empleado->total_days_off = $this->total_days_off;
                $empleado->days_off_taken = $this->days_off_taken;
                $empleado->available_days_off = $this->available_days_off;
                $empleado->save();
            }

            $newActivitie = new ActivityLog();
            $newActivitie->user_id = auth()->user()->id;
            $newActivitie->activity = 'Edición - Planilla';
            $newActivitie->detail = $record->user->name;
            $newActivitie->save();

            Alert::success('Registro de planilla', 'Registro actualizado exitosamente');
            $this->refresh();
        }
    }

    // Atributo de Livewire 4 para reemplazar el protected $listeners
    #[On('eliminarRegistro')]
    public function destroy($id)
    {
        $record = Payroll::findOrFail($id);
        $nombreEmpleado = $record->user->name;

        Payroll::destroy($id);

        $newActivitie = new ActivityLog();
        $newActivitie->user_id = auth()->user()->id;
        $newActivitie->activity = 'Registro Eliminado - Planilla';
        $newActivitie->detail = $nombreEmpleado;
        $newActivitie->save();

        Alert::success('Registro de planilla', 'Registro eliminado exitosamente');
        $this->refresh();
    }
};
?>

<div>
    <div class="lg:grid grid-cols-4 sm:grid-col-1" wire:key="{{ $selected_id ?? 'new' }}">
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

            @include('.admin.payrolls.columns.third')

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

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('abrir-pdf', (event) => {
            console.log("Evento recibido:", event);
            alert("Intentando abrir: " + event[0].url);
            window.open(event[0].url, '_blank');
        });
    });
</script>
