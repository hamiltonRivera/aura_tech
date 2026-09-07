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
        
        $expenses = Gasto::orderBy('id', 'asc')
        ->where('descripcion', 'like', '%' . $this->search . '%')->paginate(10);
        return view('livewire.daily-process.expenses.expenses', compact('expenses', 'totalGastos'));
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
