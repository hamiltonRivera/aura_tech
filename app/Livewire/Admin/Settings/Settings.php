<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Setting;
use App\Models\HistorialFactura;
use App\Models\ActivityLog;
use Livewire\WithPagination;
class Settings extends Component
{
    use WithPagination;
    public $search = '';

    public $nombre, $direccion, $ruc, $telefono, $email, $propietario, $consecutivo;
    public $selected_id, $validConsecutivo;

    public function render()
    {
        $settings = Setting::paginate(1);
        return view('livewire.admin.settings.settings', compact('settings'));
    }

    public function refresh()
    {
        return redirect('/private/admin/settings');
    }

    public function edit($id)
    {
        $record = Setting::findOrFail($id);
        $this->selected_id = $id;
        $this->nombre = $record->nombre;
        $this->direccion = $record->direccion;
        $this->ruc = $record->ruc;
        $this->telefono = $record->telefono;
        $this->email = $record->email;
        $this->propietario = $record->propietario;
        $this->consecutivo = $record->consecutivo;
    }

    public function update()
    {
       $this->validate([
            'nombre' => 'required|string',
            'direccion' => 'required|string',
            'ruc' => 'required|string',
            'telefono' => 'required|numeric',
            'email' => 'nullable|email',
            'propietario' => 'required|string',
            'consecutivo' => 'required|numeric',
        ]);

        //condicion de validar consecutivo ya usado
        $this->validConsecutivo = HistorialFactura::where('numFactura', $this->consecutivo)->count();
        if ($this->validConsecutivo) {
            session()->flash('message', 'El consecutivo ya está en uso.');

            return false;
        } else {
            if ($this->selected_id) {
                $record = Setting::findOrFail($this->selected_id);
                $record->update([
                    'nombre' => $this->nombre,
                    'direccion' => $this->direccion,
                    'ruc' => $this->ruc,
                    'telefono' => $this->telefono,
                    'email' => $this->email,
                    'propietario' => $this->propietario,
                    'consecutivo' => $this->consecutivo
                ]);

                $newActivitie = new ActivityLog();
                $newActivitie->user_id = auth()->user()->id;
                $newActivitie->activity = "Registro Modificado - Ajuste de sistema";
                $newActivitie->detail = "Datos del negocio";
                $newActivitie->save();

                Alert::success('Datos del negocio', 'Datos actualizados correctamente');
                $this->refresh();
            }
        }
    }
}
