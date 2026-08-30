<?php

namespace App\Livewire\DailyProcess\Combos;

use Livewire\Component;
use App\Models\ActivityLog;
use RealRashid\SweetAlert\Facades\Alert;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Discount;
use App\Models\ComboDetail;
class Combos extends Component
{

    use WithPagination;
    public $search = '';
    public $search_product = '';
    public $productSel;
    public $detailProduct = [];

    public $product_id, $quantity, $discount, $total_price, $total_discount, $ver_descuento_individual, $descuento_i, $description;

    public $monto_descontado_individual, $subtotalSinDescuento, $precio_descuento, $descuento_individual;

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
            ->whereAny(['descripcion', 'codigo'], 'like', '%' . $this->search_product . '%')->get();

        return view('livewire.daily-process.combos.combos', compact('products'));
    }

    public function mostarDescuentoIndividual()
    {
        if ($this->productSel) {
            if ($this->descuento_individual == "Si") {
                $this->ver_descuento_individual = true;

                // Si ya eligió un porcentaje, calculamos. Si no, dejamos los montos en 0 o vacíos temporalmente
                if ($this->descuento_i) {
                    $subtotalSinDescuento = $this->total_price * $this->quantity;
                    $this->monto_descontado_individual = round(($subtotalSinDescuento * $this->descuento_i) / 100, 2);
                    $this->precio_descuento = round($subtotalSinDescuento - $this->monto_descontado_individual, 2);
                } else {
                    $this->monto_descontado_individual = 0;
                    $this->precio_descuento = $this->total_discount * $this->quantity;
                }
            } else {
                // Si marca "No", limpiamos los valores del descuento individual
                $this->ver_descuento_individual = false;
                $this->descuento_i = null;
                $this->monto_descontado_individual = 0;
                $this->precio_descuento = $this->total_price * $this->quantity;
            }
        } else {
            $this->descuento_individual = null;
        }
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
        $this->total_price = null;
        $this->quantity = null;
        $this->product_id = null;
        $this->productSel = null;
        $this->ver_descuento_individual = false;
        $this->descuento_individual = null;
        $this->precio_descuento = null;
        $this->descuento_i = null;
    }

    // Incrementar cantidad desde la tabla
    public function incrementarCantidad($key)
    {
        if (isset($this->detailProduct[$key])) {
            // Validar stock antes de incrementar si lo deseas
            $product = Product::find($this->detailProduct[$key]['id']);
            if ($product && $this->detailProduct[$key]['cantidad'] < $product->stock) {
                $this->detailProduct[$key]['cantidad']++;
                
                // Mantiene el precio unitario que ya tenía (con o sin descuento) y recalcula el total
                $precioUnitario = $this->detailProduct[$key]['precio_venta'];
                $this->detailProduct[$key]['total'] = round($this->detailProduct[$key]['cantidad'] * $precioUnitario, 2);

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
            if ($this->detailProduct[$key]['cantidad'] > 1) {
                $this->detailProduct[$key]['cantidad']--;
                
                $precioUnitario = $this->detailProduct[$key]['precio_venta'];
                $this->detailProduct[$key]['total'] = round($this->detailProduct[$key]['cantidad'] * $precioUnitario, 2);

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

        $this->total = $suma;
        $this->totalPagado = round($this->total, 2);

        // Si ya había un descuento general aplicado, lo recalculamos también
        if ($this->descuento) {
            $this->mostrarDescuento();
        }
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

        // Verificamos si el producto ya está en la cesta temporal para acumular su cantidad
        $cantidadEnCesta = 0;
        $indexBuscar = array_search($this->productSel->id, array_column($this->detailProduct, 'product_id'));
        if ($indexBuscar !== false) {
            $cantidadEnCesta = $this->detailProduct[$indexBuscar]['quantity'];
        }

        $cantidadTotalSolicitada = $cantidadEnCesta + $this->quantity;

        // Validación estricta contra el stock actual del producto
        if ($cantidadTotalSolicitada > $this->productSel->stock) {
            session()->flash('addItem', '*No se puede agregar más de lo que hay en inventario. Stock disponible: ' . $this->productSel->stock);
            return false;
        }

        // Tomamos el precio base asignado al combo
        $precioBaseCombo = floatval($this->total_price); 
        $precioFinalUnitario = $precioBaseCombo;

        // Si se activó el descuento individual, recalculamos el precio unitario
        if ($this->descuento_individual == "Si" && $this->descuento_i) {
            $montoDescuentoUnitario = ($precioBaseCombo * $this->descuento_i) / 100;
            $precioFinalUnitario = round($precioBaseCombo - $montoDescuentoUnitario, 2);
        }

        // Estructura adaptada a las columnas reales del modelo ComboDetail y la vista
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
        $this->recalcularTotales();
    }



}
