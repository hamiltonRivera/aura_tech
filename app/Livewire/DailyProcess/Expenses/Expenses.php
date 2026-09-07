<?php

namespace App\Livewire\DailyProcess\Expenses;

use Livewire\Component;
use App\Models\ActivityLog;
use RealRashid\SweetAlert\Facades\Alert;
use Livewire\WithPagination;
use App\Models\Gasto;
class Expenses extends Component
{
    use WithPagination;
    public $search = '';
    public $descripcion, $fecha, $monto, $tipo_gasto, $selected_id;
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

    public function render()
    {   
        
        // Total acumulado de todos los gastos registrados en la base de datos
        // Sumas por mes del año actual
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
        
        $expenses = Gasto::orderBy('id', 'asc')
        ->where('descripcion', 'like', '%' . $this->search . '%')->paginate(10);
        return view('livewire.daily-process.expenses.expenses', compact('expenses','enero','febrero', 'marzo','abril','mayo','junio','julio',agosto','septiembre','octubre','noviembre','diciembre'));
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
            'monto' => 'required|numeric',
            'tipo_gasto' => 'required|string|max:23'
        ]);

        $gasto = new Gasto();
        $gasto->descripcion = ucfirst(strtolower($this->descripcion));
        $gasto->fecha = $this->fecha;
        $gasto->monto = round($this->monto, 2);
        $gasto->tipo_gasto = ucfirst(strtolower($this->tipo_gasto));
        $gasto->save();

        $newActivitie = new ActivityLog();
        $newActivitie->user_id = auth()->user()->id;
        $newActivitie->activity = "Nuevo Registro - Gasto";
        $newActivitie->detail = $this->descripcion;
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

    }

    public function update()
    {
        $this->validate([
            'descripcion' => 'required|string',
            'fecha' => 'required|date',
            'monto' => 'required|numeric',
            'tipo_gasto' => 'required|string|max:23'
        ]);

        if($this->selected_id)
        {
            $record = Gasto::findOrFail($this->selected_id);
            $record->update([
                'descripcion' => ucfirst(strtolower($this->descripcion)),
                'fecha' => $this->fecha,
                'monto' => round($this->monto, 2),
                'tipo_gasto' => ucfirst(strtolower($this->tipo_gasto))
            ]);
            $newActivitie = new ActivityLog();
            $newActivitie->user_id = auth()->user()->id;
            $newActivitie->activity = "Registro Actualizado - Gasto";
            $newActivitie->detail = $record->descripcion;
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
        $newActivitie->activity = "Registro Eliminado - producto";
        $newActivitie->detail = $record->descripcion;
        $newActivitie->save();
        Alert::warning('Gasto', 'Has eliminado el registro');
        $this->refresh();
    }
}
