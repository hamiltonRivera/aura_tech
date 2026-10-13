<?php

namespace App\Livewire\DailyProcess\Expenses;

use Livewire\Component;
use App\Models\ActivityLog;
use RealRashid\SweetAlert\Facades\Alert;
use Livewire\WithPagination;
use App\Models\Gasto;
use App\Models\Sale;
use App\Models\CashRegister;
use Carbon\Carbon;

class Expenses extends Component
{
    use WithPagination;
    public $search = '';
    public $descripcion, $fecha, $monto, $tipo_gasto, $selected_id;
    
    // Nueva variable para indicar si sale de caja
    public $from_cash_register = 'No';

    public $filtro_tipo_gasto = ''; 
    
    protected $listeners = ['eliminarRegistro' => 'destroy'];
    public $tipo_gastos = [
       'Reinversión de negocio',
       'Operacionales',
       'Administrativos',
       'Gastos Fijos',
       'Discrecionales',
       'Gastos Variables',
       'Gastos de emergencia',
       'Personales',
       'Financieros',
       'Comerciales',
       'Impuestos',
       'Otros Gastos'
    ];

    public function mount()
    {
        $this->fecha = Carbon::today()->format('Y-m-d');
        $this->from_cash_register = 'No';
    }

    public function render()
    {   
        $enero = Gasto::whereYear('fecha', date('Y'))->whereMonth('fecha', 1)->sum('monto');
        $febrero = Gasto::whereYear('fecha', date('Y'))->whereMonth('fecha', 2)->sum('monto');
        $marzo = Gasto::whereYear('fecha', date('Y'))->whereMonth('fecha', 3)->sum('monto');
        $abril = Gasto::whereYear('fecha', date('Y'))->whereMonth('fecha', 4)->sum('monto');
        $mayo = Gasto::whereYear('fecha', date('Y'))->whereMonth('fecha', 5)->sum('monto');
        $junio = Gasto::whereYear('fecha', date('Y'))->whereMonth('fecha', 6)->sum('monto');
        $julio = Gasto::whereYear('fecha', date('Y'))->whereMonth('fecha', 7)->sum('monto');
        $agosto = Gasto::whereYear('fecha', date('Y'))->whereMonth('fecha', 8)->sum('monto');
        $septiembre = Gasto::whereYear('fecha', date('Y'))->whereMonth('fecha', 9)->sum('monto');
        $octubre = Gasto::whereYear('fecha', date('Y'))->whereMonth('fecha', 10)->sum('monto');
        $noviembre = Gasto::whereYear('fecha', date('Y'))->whereMonth('fecha', 11)->sum('monto');
        $diciembre = Gasto::whereYear('fecha', date('Y'))->whereMonth('fecha', 12)->sum('monto');
        
        $query = Gasto::orderBy('id', 'asc')
            ->where('descripcion', 'like', '%' . $this->search . '%');
            
        if (!empty($this->filtro_tipo_gasto)) {
            $query->where('tipo_gasto', $this->filtro_tipo_gasto);
        }

        $totalFiltrado = $query->sum('monto');
        $expenses = $query->paginate(10);
        
        return view('livewire.daily-process.expenses.expenses', compact(
            'expenses', 'totalFiltrado', 'enero', 'febrero', 'marzo', 'abril', 
            'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
        ));
    }

    public function calcularEfectivoActualEnCaja($fechaConsulta)
    {
        $apertura = CashRegister::whereDate('date', $fechaConsulta)->sum('opening_amount');

        $ventasEfectivoPuras = Sale::whereDate('fecha', $fechaConsulta)
            ->where(function ($q) { $q->where('status', '!=', 'Anulada')->orWhereNull('status'); })
            ->where('metodoPago', 'Efectivo')->sum('totalPagado');

        $ventasEfectivoMixtas = Sale::whereDate('fecha', $fechaConsulta)
            ->where(function ($q) { $q->where('status', '!=', 'Anulada')->orWhereNull('status'); })
            ->where('metodoPago', 'Mixto')->sum('mixed_cash_amount');

        $gastosDeCaja = Gasto::whereDate('fecha', $fechaConsulta)
            ->where('from_cash_register', 'Si')->sum('monto');

        return round(floatval($apertura) + floatval($ventasEfectivoPuras) + floatval($ventasEfectivoMixtas) - floatval($gastosDeCaja), 2);
    }

    public function refresh()
    {
        return redirect('/private/expenses');
    }

    public function store()
    {
        $this->validate([
            'descripcion' => 'required|string',
            'fecha' => 'required|date',
            'monto' => 'required|numeric|min:0.01',
            'tipo_gasto' => 'required|string|max:30',
            'from_cash_register' => 'required|in:Si,No'
        ]);

        $saldoRestanteInfo = '';
        if ($this->from_cash_register === 'Si') {
            $efectivoEnEsteMomento = $this->calcularEfectivoActualEnCaja($this->fecha);
            $saldoRestanteInfo = " | Salió de Caja (Gaveta disponible: C$ {$efectivoEnEsteMomento})";
        }

        $gasto = new Gasto();
        $gasto->descripcion = ucfirst(strtolower($this->descripcion));
        $gasto->fecha = $this->fecha;
        $gasto->monto = round($this->monto, 2);
        $gasto->tipo_gasto = $this->tipo_gasto;
        $gasto->from_cash_register = $this->from_cash_register;
        $gasto->save();

        $newActivitie = new ActivityLog();
        $newActivitie->user_id = auth()->user()->id;
        $newActivitie->activity = "Nuevo Registro - Gasto";
        $newActivitie->detail = $this->descripcion . $saldoRestanteInfo;
        $newActivitie->save();

        Alert::success('Gasto', 'Gasto registrado exitosamente');
        $this->refresh();
    }

    public function edit($id)
    {
        $record = Gasto::findOrFail($id);
        $this->selected_id = $id;
        $this->descripcion = $record->descripcion;
        $this->fecha = $record->fecha;
        $this->monto = $record->monto;
        $this->tipo_gasto = $record->tipo_gasto;
        $this->from_cash_register = $record->from_cash_register ?? 'No';
    }

    public function update()
    {
        $this->validate([
            'descripcion' => 'required|string',
            'fecha' => 'required|date',
            'monto' => 'required|numeric|min:0.01',
            'tipo_gasto' => 'required|string|max:30',
            'from_cash_register' => 'required|in:Si,No'
        ]);

        if($this->selected_id)
        {
            $record = Gasto::findOrFail($this->selected_id);
            $record->update([
                'descripcion' => ucfirst(strtolower($this->descripcion)),
                'fecha' => $this->fecha,
                'monto' => round($this->monto, 2),
                'tipo_gasto' => $this->tipo_gasto,
                'from_cash_register' => $this->from_cash_register
            ]);
            $newActivitie = new ActivityLog();
            $newActivitie->user_id = auth()->user()->id;
            $newActivitie->activity = "Registro Actualizado - Gasto";
            $newActivitie->detail = $record->descripcion . " | Sale de caja: " . $this->from_cash_register;
            $newActivitie->save();

            Alert::success('Gasto', 'Gasto actualizado exitosamente');
            $this->refresh();
        }
    }

    public function destroy($id)
    {
        $record = Gasto::findOrFail($id);
        Gasto::destroy($id);

        $newActivitie = new ActivityLog();
        $newActivitie->user_id = auth()->user()->id;
        $newActivitie->activity = "Registro Eliminado - Gasto";
        $newActivitie->detail = $record->descripcion;
        $newActivitie->save();
        
        Alert::warning('Gasto', 'Has eliminado el registro');
        $this->refresh();
    }
}
