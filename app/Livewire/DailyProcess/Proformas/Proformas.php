<?php

namespace App\Livewire\DailyProcess\Proformas;

use Livewire\Component;
use App\Models\Discount;
use App\Models\Product;
use App\Models\Client;
use App\Models\ActivityLog;
use RealRashid\SweetAlert\Facades\Alert;
use Livewire\WithPagination;
use App\Models\Cambio;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
class Proformas extends Component
{

     use WithPagination;
    public $search_product = '', $search_client = '', $precioOriginal;
    protected $listeners = ['eliminarRegistro' => 'destroy'];

    public $sale_id, $product_id, $precio, $cantidad, $total, $producto;
    public $productSel;
    public $detailProduct = [];

     //porcentaje de descuentos
    public $descuentos;

    public $metodos = [
        'Efectivo',
        'Transferencia Bancaria'
    ];

    public $descuento_i, $ver_descuento_individual = false, $descuento_individual, $precio_descuento, $monto_descontado_individual;


    //mostrar y ocultar total cuando hay descuento
    public $descuentoSel = false, $ocultarTotal = true;

    public $client_id, $fecha, $numFactura, $descuento, $totalPagado, $fechaVencimiento,
        $cambio, $totalRecibido, $totalDescuento, $totalPagadoDescuento, $user_id, $metodoPago, $exchangeRate;

    

     public function updatedCantidad()
    {
        $this->precio = 0;
        if ($this->productSel) {
            if ($this->cantidad >= 3) {
                $this->precio = $this->productSel->precio_venta_mayor;
            } else {
                $this->precio = $this->productSel->precio_venta_unidad;
            }
        }
    }

    public function mount()
    {
        // Obtener el registro de cambio para la fecha actual
        $cambio = Cambio::where('fecha', today())->first();

        // Verificar si se encontró un registro para la fecha actual
        if ($cambio) {
            $this->exchangeRate = $cambio->valor;
        } else {
            $this->exchangeRate = "Sin registro";
        }
    }
    public function render()
    {  
        $clients = Client::orderBy('id', 'asc')
            ->whereAny(['nombreApellido', 'telefono'], 'like', '%' . $this->search_client . '%')->get();

        $products = Product::orderBy('id', 'asc')
            ->whereAny(['descripcion', 'codigo'], 'like', '%' . $this->search_product . '%')->get();

        $this->fecha = now()->format('Y-m-d');
        $this->descuentos = Discount::orderBy('id', 'asc')->get();


        return view('livewire.daily-process.proformas.proformas',  compact('clients', 'products'));
    }

    public function refresh()
    {
        return redirect('/private/proforma');
    }
    
     public function mostrarDescuento()
    {
        if ($this->descuento) {
            // Calcula el descuento sobre el total acumulado
            $this->totalDescuento = round(($this->total * $this->descuento) / 100, 2);

            // Calcula el total con el descuento aplicado
            $this->totalPagadoDescuento = round($this->total - $this->totalDescuento, 2);
            $this->totalPagado = $this->totalPagadoDescuento;
        }
    }

    public function mostarDescuentoIndividual()
    {
        if ($this->productSel) {
            if ($this->descuento_individual == "Si") {
                $this->ver_descuento_individual = true;
                
                // Si ya eligió un porcentaje, calculamos. Si no, dejamos los montos en 0 o vacíos temporalmente
                if ($this->descuento_i) {
                    $subtotalSinDescuento = $this->precio * $this->cantidad;
                    $this->monto_descontado_individual = round(($subtotalSinDescuento * $this->descuento_i) / 100, 2);
                    $this->precio_descuento = round($subtotalSinDescuento - $this->monto_descontado_individual, 2);
                } else {
                    $this->monto_descontado_individual = 0;
                    $this->precio_descuento = $this->precio * $this->cantidad;
                }
            } else {
                // Si marca "No", limpiamos los valores del descuento individual
                $this->ver_descuento_individual = false;
                $this->descuento_i = null;
                $this->monto_descontado_individual = 0;
                $this->precio_descuento = $this->precio * $this->cantidad;
            }
        } else {
            $this->descuento_individual = null;
        }
    }


    //oculta el total sin descuento
    public function ocultarTotal()
    {
        $this->ocultarTotal = false;
    }

     public function buscarProducto()
    {
        $this->precio_descuento = $this->precio;
        $this->productSel = Product::whereAny(['codigo', 'descripcion'], 'like', '%' . $this->search_product . '%')->first();

        if ($this->productSel) {
            $this->cantidad = 1;
            $this->precio = floatval($this->productSel->precio_venta_unidad);

            $descripcionLimpia = trim(strtolower($this->productSel->descripcion));
            $combo = \App\Models\Combo::whereRaw('TRIM(LOWER(description)) = ?', [$descripcionLimpia])->first();

            if ($combo) {
                // Verificar cada componente del combo
                $comboDetails = \App\Models\ComboDetail::where('combo_id', $combo->id)->get();
                foreach ($comboDetails as $detail) {
                    $componentProduct = Product::find($detail->product_id);
                    $yaComprometido = $this->obtenerCantidadComprometidaEnCesta($detail->product_id);
                    $stockDisponibleReal = $componentProduct ? ($componentProduct->stock - $yaComprometido) : 0;

                    if (!$componentProduct || $stockDisponibleReal < $detail->quantity) {
                        $nombreArticulo = $componentProduct ? $componentProduct->descripcion : 'Desconocido';
                        session()->flash('producto', "*No se puede vender el combo. El artículo '{$nombreArticulo}' no tiene stock disponible en la tienda.");
                        return;
                    }
                }
            } else {
                // Producto Individual
                $yaComprometido = $this->obtenerCantidadComprometidaEnCesta($this->productSel->id);
                $stockDisponibleReal = $this->productSel->stock - $yaComprometido;

                if ($stockDisponibleReal <= 0) {
                    session()->flash('producto', "*El producto '{$this->productSel->descripcion}' no posee más stock disponible (Stock en tienda: {$this->productSel->stock}, ya en cesta: {$yaComprometido}).");
                }
            }
        } else {
            session()->flash('producto', '*El producto digitado no existe o es incorrecto.');
        }
        
    }

    public function limpiarBusqueda()
    {
        $this->search_product = null;
        $this->precio = null;
        $this->cantidad = null;
        $this->product_id = null;
        $this->productSel = null;
        $this->ver_descuento_individual = false;
        $this->descuento_individual = null;
        $this->precio_descuento = null;
        $this->descuento_i = null;
    }

    public function calcular()
    {
        if (!$this->productSel) {
            return $this->totalPagado = 0;
        }

        if (!$this->cantidad) $this->cantidad = 1;

        if ($this->cantidad > $this->productSel->stock) {
            session()->flash('cantidad', '*La cantidad digitada no puede ser mayor al stock disponible.');
            $this->cantidad = $this->productSel->stock;
        }

        if ($this->cantidad < 1) {
            session()->flash('cantidad', '*La cantidad digitada no puede ser menor a 1.');
            $this->cantidad = 1;
        }

        // Precio por mayor o unidad base
        $this->precio = $this->cantidad >= 3
            ? floatval($this->productSel->precio_venta_mayor)
            : floatval($this->productSel->precio_venta_unidad);

        $this->totalPagado = round($this->precio * $this->cantidad, 2);

        // Si hay descuento individual activo, recalculamos al cambiar la cantidad
        if ($this->descuento_individual == "Si" && $this->descuento_i) {
            $this->mostarDescuentoIndividual();
        }
    }

      //radio button que valida si se va a aplicar descuento individual
    public function getPrecio()
    {
        return $this->descuento_individual == "Si" ? $this->precio_descuento : $this->precio;
    }

    //funcion para agregar el producto al carrito
    public function addItem($array)
    {
        if ($this->productSel == null) {
            session()->flash('addItem', '*Campos Vacíos. Agrega un producto primero.');
            return false;
        }

        $descripcionLimpia = trim(strtolower($this->productSel->descripcion));
        $combo = \App\Models\Combo::whereRaw('TRIM(LOWER(description)) = ?', [$descripcionLimpia])->first();

        if ($combo) {
            // Validar stock de los componentes del combo
            $comboDetails = \App\Models\ComboDetail::where('combo_id', $combo->id)->get();

            foreach ($comboDetails as $detail) {
                $componentProduct = Product::find($detail->product_id);

                if (!$componentProduct) {
                    session()->flash('addItem', "*El componente ID {$detail->product_id} no existe.");
                    return false;
                }

                $yaComprometido = $this->obtenerCantidadComprometidaEnCesta($detail->product_id);
                $unidadesRequeridasTotal = $yaComprometido + ($detail->quantity * $this->cantidad);

                if ($componentProduct->stock < $unidadesRequeridasTotal) {
                    session()->flash('addItem', "*No hay stock suficiente del artículo '{$componentProduct->descripcion}' para agregar este combo.");
                    return false;
                }
            }
        } else {
            // Validar stock de Producto Individual acumulado
            $yaComprometido = $this->obtenerCantidadComprometidaEnCesta($this->productSel->id);
            $unidadesRequeridasTotal = $yaComprometido + $this->cantidad;

            if ($this->productSel->stock < $unidadesRequeridasTotal) {
                session()->flash('addItem', "*No hay stock suficiente para '{$this->productSel->descripcion}'. Stock real: {$this->productSel->stock}, ya en la cesta: {$yaComprometido}.");
                return false;
            }
        }

        // Aplicar precio con descuento
        $precioFinalUnitario = $this->precio;
        if ($this->descuento_individual == "Si" && $this->descuento_i) {
            $precioUnitarioBase = $this->precio;
            $montoDescuentoUnitario = ($precioUnitarioBase * $this->descuento_i) / 100;
            $precioFinalUnitario = round($precioUnitarioBase - $montoDescuentoUnitario, 2);
        }

        // Agregar o actualizar cesta
        $indexBuscar = array_search($this->productSel->id, array_column($this->detailProduct, 'id'));

        if ($indexBuscar !== false && !$combo) {
            $this->detailProduct[$indexBuscar]['cantidad'] += $this->cantidad;
            $this->detailProduct[$indexBuscar]['total'] = round($this->detailProduct[$indexBuscar]['cantidad'] * $this->detailProduct[$indexBuscar]['precio_venta'], 2);
        } else {
            $datos = [
                "id" => $this->productSel->id,
                "descripcion" => $this->productSel->descripcion,
                "precio_venta" => $precioFinalUnitario, 
                "cantidad" => $this->cantidad,
                "total" => round($precioFinalUnitario * $this->cantidad, 2),
            ];
            array_push($this->detailProduct, $datos);
        }

        $this->limpiarBusqueda();
        $this->recalcularTotales();
    }
    
     //funcion para eliminar el producto de la cesta
    public function destroy($key)
    {
        array_splice($this->detailProduct, $key, 1);
        $valorInicial = 0;

        $suma = array_reduce($this->detailProduct, function ($acc, $arr) {
            return $acc + $arr['total'];
        }, $valorInicial);

        $this->total = $suma;
        $this->totalPagado = round($this->total, 2);
    }

 public function store()
{
    $client = DB::table('clients')->where('id', $this->client_id)->first();
    $nombreCliente = $client ? $client->nombreApellido : 'Cliente General';

    session()->forget('proformaData');
    session([
        'proformaData' => [
            'cliente'     => $nombreCliente,
            'fecha'       => $this->fecha,
            'detalles'    => $this->detailProduct,
            'totalPagado' => $this->totalPagado
        ]
    ]);
    session()->save();

    $newActivity = new ActivityLog();
    $newActivity->user_id = auth()->user()->id;
    $newActivity->activity = "Registro de Proforma";
    $newActivity->detail = "Proforma | Cliente: " . ($client ? $client->nombreApellido : 'N/A');
    $newActivity->save();

 

    // Limpiamos todas las variables y la tabla por completo
    $this->detailProduct = [];
    $this->total = 0;
    $this->totalPagado = 0;
    $this->client_id = null;
    $this->search_client = '';
    $this->search_product = '';
    $this->productSel = null;
    Alert::success('Proforma', 'Proforma generada exitosamente');
    
    // Disparamos el evento para que abra el PDF en una pestaña nueva sin perder tu vista limpia
    $this->dispatch('abrir-pdf', url: route('proforma.pdf'));
    

          
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

    private function obtenerCantidadComprometidaEnCesta($productId)
    {
        $totalComprometido = 0;

        foreach ($this->detailProduct as $item) {
            $descripcionLimpia = trim(strtolower($item['descripcion']));
            $combo = \App\Models\Combo::whereRaw('TRIM(LOWER(description)) = ?', [$descripcionLimpia])->first();

            if ($combo) {
                // Si el ítem del carrito es un Combo, sumamos las unidades que requiere este productId
                $comboDetails = \App\Models\ComboDetail::where('combo_id', $combo->id)->get();
                foreach ($comboDetails as $detail) {
                    if ($detail->product_id == $productId) {
                        $totalComprometido += ($detail->quantity * $item['cantidad']);
                    }
                }
            } else {
                // Si el ítem del carrito es un producto individual con el mismo ID
                if ($item['id'] == $productId) {
                    $totalComprometido += $item['cantidad'];
                }
            }
        }

        return $totalComprometido;
    }

}

