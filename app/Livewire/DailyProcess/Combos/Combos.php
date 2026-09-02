<?php

namespace App\Livewire\DailyProcess\Combos;

use Livewire\Component;
use App\Models\ActivityLog;
use App\Models\Category;
use RealRashid\SweetAlert\Facades\Alert;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Discount;
use App\Models\ComboDetail;
use App\Models\Combo;
class Combos extends Component
{

    use WithPagination;
    public $search = '';
   
    public $productSel;
    public $detailProduct = [];

    public $product_id, $quantity, $discount, $total_price, $description, $stock;


    //porcentaje de descuentos
    public $descuentos;


    public function updatedSearchProduct()
    {
        $this->buscarProducto();
    }

    public function updatedQuantity($value)
    {
        if ($this->productSel) {
            if ($value < 1 || $value === "") {
                $this->quantity = 1;
            } elseif ($value > $this->productSel->stock) {
                $this->quantity = $this->productSel->stock;
            }
        } else {
            if ($value < 1) {
                $this->quantity = 1;
            }
        }
    }

    public function render()
    {
        $this->descuentos = Discount::orderBy('id', 'asc')->get();

        $products = Product::orderBy('id', 'asc')
            ->whereAny(['descripcion', 'codigo'], 'like', '%' . $this->search . '%')->get();

        return view('livewire.daily-process.combos.combos', compact('products'));
    }


    public function refresh()
    {
        return redirect('/private/combos');
    }

    public function buscarProducto()
    {
        $this->productSel = Product::whereAny(['codigo', 'descripcion'], 'like', '%' . $this->search_product . '%')->first();

        if ($this->productSel) {
            $this->quantity = 1;

            if ($this->productSel->stock <= 0) {
                session()->flash('producto', '*El producto seleccionado no tiene stock disponible.');
            } elseif ($this->quantity > $this->productSel->stock) {
                session()->flash('producto', '*No se puede agregar más de lo que hay en inventario. Stock disponible: ' . $this->productSel->stock);
            }
        } else {
            session()->flash('producto', '*El producto digitado no existe o es incorrecto.');
        }
    }

    public function limpiarBusqueda()
    {
        $this->search_product = null;
        $this->quantity = null;
        $this->product_id = null;
        $this->productSel = null;
    }

    // Incrementar cantidad desde la tabla
    public function incrementarCantidad($key)
    {
        if (isset($this->detailProduct[$key])) {
            $product = Product::find($this->detailProduct[$key]['product_id']);
            if ($product && $this->detailProduct[$key]['quantity'] < $product->stock) {
                $this->detailProduct[$key]['quantity']++;
                
                $precioUnitario = $this->detailProduct[$key]['precio_venta'];
                $this->detailProduct[$key]['total'] = round($this->detailProduct[$key]['quantity'] * $precioUnitario, 2);

                $this->recalcularTotales();
            } else {
                session()->flash('addItem', '*No hay más stock disponible para este producto.');
            }
        }
    }
   
    // Decrementar cantidad desde la tabla
    public function decrementarCantidad($key)
    {
        if (isset($this->detailProduct[$key])) {
            if ($this->detailProduct[$key]['quantity'] > 1) {
                $this->detailProduct[$key]['quantity']--;
                
                $precioUnitario = $this->detailProduct[$key]['precio_venta'];
                $this->detailProduct[$key]['total'] = round($this->detailProduct[$key]['quantity'] * $precioUnitario, 2);
                $this->recalcularTotales();
            }
        }
    }

    // Método auxiliar para no repetir código de suma de totales
    private function recalcularTotales()
    {
        $suma = array_reduce($this->detailProduct, function ($acc, $arr) {
            return $acc + $arr['total'];
        }, 0);

        $this->total_price = round($suma, 2);
    }

    public function addItem($array = null)
    {
        if ($this->productSel == null) {
            session()->flash('addItem', '*Campos Vacíos. Agrega un producto primero.');
            return false;
        }

        if (!$this->quantity || $this->quantity < 1) {
            $this->quantity = 1;
        }

        $cantidadEnCesta = 0;
        $indexBuscar = array_search($this->productSel->id, array_column($this->detailProduct, 'product_id'));
        if ($indexBuscar !== false) {
            $cantidadEnCesta = $this->detailProduct[$indexBuscar]['quantity'];
        }

        $cantidadTotalSolicitada = $cantidadEnCesta + $this->quantity;

        if ($cantidadTotalSolicitada > $this->productSel->stock) {
            session()->flash('addItem', '*No se puede agregar más de lo que hay en inventario. Stock disponible: ' . $this->productSel->stock);
            return false;
        }

        $precioFinalUnitario = floatval($this->total_price); 

        $datos = [
            "product_id" => $this->productSel->id,
            "descripcion" => $this->productSel->descripcion,
            "precio_venta" => $precioFinalUnitario, 
            "quantity" => $this->quantity,
            "total" => round($precioFinalUnitario * $this->quantity, 2),
        ];

        if ($indexBuscar !== false) {
            $this->detailProduct[$indexBuscar]['quantity'] += $this->quantity;
            $this->detailProduct[$indexBuscar]['total'] = round($this->detailProduct[$indexBuscar]['quantity'] * $this->detailProduct[$indexBuscar]['precio_venta'], 2);
        } else {
            array_push($this->detailProduct, $datos);
        }

        $this->limpiarBusqueda();
    }

    //funcion para eliminar el producto de la cesta
    public function destroy($key)
    {
        array_splice($this->detailProduct, $key, 1);
        $valorInicial = 0;

        $suma = array_reduce($this->detailProduct, function ($acc, $arr) {
            return $acc + $arr['total'];
        }, $valorInicial);

        $this->total_price = round($suma, 2);
    }

    public function store()
    {
        $this->validate([
            'description' => 'required|string|max:255',
            'total_price' => 'required|numeric|min:0',
        ]);

        $category = Category::where('name', 'combos')->first();

        $newCombo = new Combo();
        $newCombo->description = $this->description;
        $newCombo->total_price = $this->total_price;
        $newCombo->save();
        
        //itera los productos añadidos a la cesta
        foreach ($this->detailProduct as $item) {
            $comboDetail = new ComboDetail();
            $comboDetail->combo_id = $newCombo->id;
            $comboDetail->product_id = $item['product_id'];
            $comboDetail->quantity = $item['quantity'];
            $comboDetail->save();
        }

        //guarda el producto 
        $newProduct = new Product();
        $newProduct->descripcion = $this->description;
        $newProduct->stock = $this->stock; // Asignar un stock alto para el combo
        $newProduct->precio_compra = 0; // Asignar un precio de compra de 0 para el combo
        $newProduct->precio_venta_unidad = $this->total_price; // Asignar el precio de venta del combo
        $newProduct->precio_venta_mayor = $this->total_price; // Asignar el precio de venta del combo
        $newProduct->codigo = $this->generateUniqueCode();
        $newProduct->category_id = $category->id;
        $newProduct->save();

        $newActivitie = new ActivityLog();
        $newActivitie->user_id = auth()->user()->id;
        $newActivitie->activity = "Nuevo Registro - Combo";
        $newActivitie->detail = $newCombo->description;
        $newActivitie->save();

        Alert::success('Combo', 'Combo creado exitosamente');
        $this->refresh();
    }

    public function generateUniqueCode()
    {
        do {
            $code = chr(mt_rand(65, 90)) . mt_rand(10000000, 99999999);
        } while (Product::where('codigo', $code)->exists());
        
        return $code;
    }

}
