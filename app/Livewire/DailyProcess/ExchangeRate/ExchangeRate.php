<?php

namespace App\Livewire\DailyProcess\ExchangeRate;

use Livewire\Component;
use App\Models\ActivityLog;
use App\Models\Cambio;
use RealRashid\SweetAlert\Facades\Alert;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CambioImport;
class ExchangeRate extends Component
{

    use WithPagination;
    use WithFileUploads;

    public $search = '';
     protected $listeners = ['eliminarRegistro' => 'destroy'];

    public $fecha, $valor, $selected_id, $carga;


    public function render()
    {
        $tasas = Cambio::orderBy('id', 'asc')
         ->where('fecha', 'like', '%' . $this->search . '%' . '%')->paginate(10);
        return view('livewire.daily-process.exchange-rate.exchange-rate', compact('tasas'));
    }

    public function refresh()
    {
        return redirect('/private/exchange_rate');
    }

    public function store()
    {
        $this->validate([
            'valor' => 'required|numeric',
            'fecha' => 'required|date|unique:cambios,fecha,except,id'
        ]);

        $tasa = new Cambio();
        $tasa->fecha = $this->fecha;
        $tasa->valor = $this->valor;
        $tasa->save();

        $newActivity = new ActivityLog();
        $newActivity->user_id = auth()->user()->id;
        $newActivity->activity = "Nuevo Registro - Tasa de cambio";
        $newActivity->detail = $this->fecha;
        $newActivity->save();

        Alert::success('Tasa de cambio', 'Tasa registrada exitosamente');
        $this->refresh();
    }

    public function edit($id)
    {
      $record = Cambio::findOrFail($id);
      $this->valor = floatval($record->valor);
      $this->selected_id = $id; $this->fecha = $record->fecha;
    }

    public function update()
    {
        $this->validate([
            'valor' => 'required|numeric',
            'fecha' => 'required|date'
        ]);

        if($this->selected_id)
        {
            $record = Cambio::findOrFail($this->selected_id);
            $record->update([
                'valor' => $this->valor,
                'fecha' => $this->fecha
            ]);

          $newActivity = new ActivityLog();
          $newActivity->user_id = auth()->user()->id;
          $newActivity->activity = "Registro Actualizado - Tasa de cambio";
          $newActivity->detail = $this->fecha;
          $newActivity->save();

          Alert::success('Tasa de cambio', 'Tasa actualizada exitosamente');
          $this->refresh();

        }
    }

    public function destroy($id)
    {
        $record = Cambio::findOrFail($id);
        Cambio::destroy($id);

        $newActivity = new ActivityLog();
        $newActivity->user_id = auth()->user()->id;
        $newActivity->activity = "Registro Eliminado - Tasa de cambio";
        $newActivity->detail = $record->fecha;
        $newActivity->save();
        Alert::warning('Tasa de cambio', 'Has eliminado el registro');
        $this->refresh();

    }

    public function import()
    {
      $this->validate([
          'carga' => 'required|file|mimes:xlsx|max:3072'
      ]);
      $this->carga->store('subida_archivos', 'public');
      Excel::import(new CambioImport, $this->carga);
      Alert::success('Carga', 'Carga de archivo exitosa');

      $newActivity = new ActivityLog();
      $newActivity->user_id = auth()->user()->id;
        $newActivity->activity = "Carga de archivo - Tasa de cambio";
        $newActivity->detail = now();
        $newActivity->save();
      $this->refresh();
    }


public function deleteAll()
    {
        Cambio::truncate();
        $activity = new ActivityLog();
        $activity->user_id = auth()->user()->id;
        $activity->activity = "Eliminación masiva - Tasa de cambio";
        $activity->detail = "Se eliminaron todos los registros de tasa de cambio";
        $activity->save();
        Alert::warning('Tasa de cambio', 'Se han eliminado todos los registros de tasa de cambio');
        $this->refresh();
    }
}
