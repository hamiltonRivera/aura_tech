<?php

namespace App\Livewire\Admin\Discounts;

use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;
use Livewire\WithPagination;
use App\Models\Discount;
use App\Models\ActivityLog;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DiscountsImport;
use Livewire\WithFileUploads;
class Discounts extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $percent, $selected_id, $carga;
     protected $listeners = ['eliminarRegistro' => 'destroy'];

    public function render()
    {
        $discounts = Discount::orderBy('id', 'asc')->paginate(6);
        return view('livewire.admin.discounts.discounts', compact('discounts'));
    }

    public function refresh()
    {
        return redirect('/private/admin/discounts');
    }

    public function store()
    {
         $this->validate([
             'percent' => 'required|numeric'
         ]);

        $new_individual = new Discount();
        $new_individual->percent = $this->percent;
        $new_individual->save();



        $newActivitie = new ActivityLog();
        $newActivitie->user_id = auth()->user()->id;
        $newActivitie->activity = "Nuevo Registro - Descuento";
        $newActivitie->detail = $this->percent;
        $newActivitie->save();
        Alert::success('Descuento', 'Descuento registrado exitosamente');
        $this->refresh();

    }

    public function edit($id)
    {
        $record = Discount::findOrFail($id);
        $this->selected_id = $id;
        $this->percent = $record->percent;
    }

    public function update()
    {
        $validate = $this->validate([
            'percent' => 'required|numeric'
        ]);

        if($this->selected_id){
            $record = Discount::findOrFail($this->selected_id);
            $record->update($validate);

            $newActivitie = new ActivityLog();
            $newActivitie->user_id = auth()->user()->id;
            $newActivitie->activity = "Registro Modificado - Descuento";
            $newActivitie->detail = $record->percent;
            $newActivitie->save();
            Alert::success('Descuento', 'Descuento registrado exitosamente');
            $this->refresh();
        }
    }

    public function destroy($id)
    {
        $record = Discount::findOrFail($id);
        Discount::destroy($id);

        $newActivitie = new ActivityLog();
        $newActivitie->user_id = auth()->user()->id;
        $newActivitie->activity = "Registro Eliminado - Descuento";
        $newActivitie->detail = $record->percent;
        $newActivitie->save();

        Alert::warning('Descuento', 'Has eliminado el registro');
        $this->refresh();
    }

    public function import()
    {
        $this->validate([
          'carga' => 'required|file|mimes:xlsx|max:3072'
      ]);

        $this->carga->store('subida_archivos', 'public');

        Excel::import(new DiscountsImport, $this->carga);

      $activity = new ActivityLog();
      $activity->user_id = auth()->user()->id;
      $activity->activity = "Carga de archivo excel - Descuentos";
      $activity->detail = "Subida de archivo";
      $activity->save();

      Alert::success('Carga', 'Carga de archivo exitosa');
      $this->refresh();
    }

    public function deleteAll()
    {
        Discount::truncate();

        $activity = new ActivityLog();
        $activity->user_id = auth()->user()->id;
        $activity->activity = "Eliminación masiva - Descuentos";
        $activity->detail = "Se eliminaron todos los registros de descuentos";
        $activity->save();

        Alert::warning('Descuentos', 'Se han eliminado todos los registros de descuentos');
        $this->refresh();
    }
}
