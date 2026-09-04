<?php

namespace App\Livewire\DailyProcess\Combos;

use Livewire\Component;
use App\Models\ActivityLog;
use RealRashid\SweetAlert\Facades\Alert;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\ComboDetail;
use App\Models\Combo;

class CombosEUD extends Component
{   

    use WithPagination;
    public $search_combo = '';
    public $comboSel;
    public $description, $total_price;
    public $combo_id, $product_id,$quantity;
    
    protected $listeners = ['eliminarRegistro' => 'destroy'];
    public function render()
    {   
        $combos = Combo::where('description', 'like', '%'. $this->search_combo . '%')->paginate(10);
        return view('livewire.daily-process.combos.combos-e-u-d',compact('combos'));
    }
    
     public function refresh()
    {
        return redirect('/private/combos_e_u_d');
    }
    
    public function edit($id)
    {
        $record = Combo::findOrFail($id);
        $this->comboSel = $id;
        $this->description = $record->description;
        $this->total_price = $record->total_price;
    } 

    public function update()
    {
        $validation = $this->validate([
            'description' => 'required|string',
            'total_price' => 'required|numeric',
        ]);

        $record = Combo::findOrFail($this->comboSel);
        $oldDescription = $record->description;

        // Actualizamos el combo
        $record->update($validation);

        // Actualizamos en cascada el producto gemelo en la tabla 'products'
        $product = Product::where('descripcion', $oldDescription)->first();
        if ($product) {
            $product->descripcion = $this->description;
            $product->precio_venta_unidad = $this->total_price;
            $product->precio_venta_mayor = $this->total_price;
            $product->save();
        }

        $newActivity = new ActivityLog();
        $newActivity->user_id = auth()->user()->id;
        $newActivity->activity = "Actualización de registro - combo";
        $newActivity->detail = $this->description;
        $newActivity->save();

        Alert::success('Combo', 'Combo actualizado exitosamente');
        $this->refresh();
    }
    
    public function destroy($id)
    {
        $record = Combo::findOrFail($id);

        // Buscamos y eliminamos en cascada el producto gemelo en la tabla 'products'
        $product = Product::where('descripcion', $record->description)->first();
        if ($product) {
            $product->delete();
        }

        // Eliminamos el combo (los combo_details se borran solos si configuraste onDelete('cascade') en la migración)
        $record->delete();

        $newActivity = new ActivityLog();
        $newActivity->user_id = auth()->user()->id;
        $newActivity->activity = "Eliminación de registro - combo";
        $newActivity->detail = $record->description;
        $newActivity->save();

        Alert::success('Combo', 'Combo eliminado exitosamente');
        $this->refresh();
    }
   
}
