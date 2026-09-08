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
    public $search_combo = '', $search_items = '';
    public $comboSel, $productoSel;
    public $description, $total_price;
    public $combo_id, $product_id, $quantity;
    public $itemsCombo = [];

    protected $listeners = ['eliminarRegistro' => 'destroy'];
    public function render()
    {
        $combos = Combo::where('description', 'like', '%' . $this->search_combo . '%')->paginate(10);

        // Búsqueda en vivo de productos por descripción o código
        $products = Product::orderBy('id', 'asc')
            ->where('descripcion', 'like', '%' . $this->search_items . '%')
            ->orWhere('codigo', 'like', '%' . $this->search_items . '%')
            ->get();
        return view('livewire.daily-process.combos.combos-e-u-d', compact('combos', 'products'));
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

        $details = ComboDetail::with('product')->where('combo_id', $id)->get();
        $this->itemsCombo = [];

        foreach ($details as $detail) {
            $this->itemsCombo[] = [
                'id'          => $detail->id,
                'product_id'  => $detail->product_id,
                'descripcion' => $detail->product->descripcion ?? 'Producto no encontrado',
                'cantidad'    => $detail->quantity,
                'stock'       => $detail->product->stock ?? 0 // Campo exacto del modelo Product
            ];
        }
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

    public function buscarProducto($id)
    {
        if (!empty($id)) {
            $this->productoSel = Product::find($id);
            $this->product_id = $id;
            $this->quantity = 1; // <-- Asigna 1 automáticamente al seleccionar
        } else {
            $this->productoSel = null;
            $this->product_id = null;
            $this->quantity = null;
        }
    }

    public function clearFields()
    {

        $this->productoSel = null;
        $this->product_id = null;
        $this->quantity = null;
        $this->search_items = '';
    }

    public function addItem()
    {
        if (empty($this->productoSel)) {
            session()->flash('error_product', 'Debes seleccionar un producto.');
            return;
        }

        $cant = max(1, (int)$this->quantity);

        // Verificar si el producto ya está en la lista actual
        $index = array_search($this->productoSel->id, array_column($this->itemsCombo, 'product_id'));

        if ($index !== false) {
            $this->itemsCombo[$index]['cantidad'] += $cant;
        } else {
            $this->itemsCombo[] = [
                'id' => null,
                'product_id' => $this->productoSel->id,
                'descripcion' => $this->productoSel->descripcion,
                'cantidad' => $cant
            ];
        }

        // Limpiar campos tras añadir
        $this->clearFields();
    }

    public function removeItem($index)
    {
        unset($this->itemsCombo[$index]);
        $this->itemsCombo = array_values($this->itemsCombo); // Reindexar
    }

    // Incrementar cantidad sin exceder el stock del producto
    public function incrementarCantidad($key)
    {
        
      if (isset($this->itemsCombo[$key])) {
        $stockDisponible = (int) $this->itemsCombo[$key]['stock'];
        $nombreItem = $this->itemsCombo[$key]['descripcion'];

        if ($this->itemsCombo[$key]['cantidad'] < $stockDisponible) {
            $this->itemsCombo[$key]['cantidad']++;
        } else {
            session()->flash('error_stock', "El ítem {$nombreItem} que intentas incrementar no tiene más de {$stockDisponible} en inventario.");
        }
    }
    }

    // Decrementar cantidad sin bajar de 1
    public function decrementarCantidad($key)
    {
        if (isset($this->itemsCombo[$key])) {
            if ($this->itemsCombo[$key]['cantidad'] > 1) {
                $this->itemsCombo[$key]['cantidad']--;
            }
        }
    }
}
