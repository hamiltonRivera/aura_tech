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

            if ($this->productSel->stock <= 0) {
                session()->flash('producto', '*El producto seleccionado no tiene stock disponible.');
                // ❌ ya no lo reseteamos a null
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

        // Determinamos si se aplicó descuento individual para guardar el precio unitario final con descuento
        $precioFinalUnitario = $this->precio;
        if ($this->descuento_individual == "Si" && $this->descuento_i) {
            $precioUnitarioBase = $this->precio;
            $montoDescuentoUnitario = ($precioUnitarioBase * $this->descuento_i) / 100;
            $precioFinalUnitario = round($precioUnitarioBase - $montoDescuentoUnitario, 2);
        }

        $datos = [
            "id" => $this->productSel->id,
            "descripcion" => $this->productSel->descripcion,
            "precio_venta" => $precioFinalUnitario, // Guardamos el precio unitario ya descontado
            "cantidad" => $this->cantidad,
            "total" => round($precioFinalUnitario * $this->cantidad, 2),
        ];

        $indexBuscar = array_search($this->productSel->id, array_column($this->detailProduct, 'id'));

        if ($indexBuscar !== false) {
            $this->detailProduct[$indexBuscar]['cantidad'] += $this->cantidad;
            $this->detailProduct[$indexBuscar]['total'] = round($this->detailProduct[$indexBuscar]['cantidad'] * $this->detailProduct[$indexBuscar]['precio_venta'], 2);
        } else {
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
    // 1. Buscamos el cliente para obtener su nombre real (o asignar 'Cliente General')
    $client = DB::table('clients')->where('id', $this->client_id)->first();
    $nombreCliente = $client ? $client->nombreApellido : 'Cliente General';

    // 2. Limpiamos y guardamos los datos frescos en la sesión
    session()->forget('proformaData');
    
    session([
        'proformaData' => [
            'cliente'     => $nombreCliente,
            'fecha'       => $this->fecha,
            'detalles'    => $this->detailProduct,
            'totalPagado' => $this->totalPagado
        ]
    ]);
    
    // Forzamos a que la sesión se guarde inmediatamente
    session()->save();

    // Registro de actividad...
    $newActivity = new ActivityLog();
    $newActivity->user_id = auth()->user()->id;
    $newActivity->activity = "Registro de Proforma";
    $newActivity->detail = "Proforma | Cliente: " . ($client ? $client->nombreApellido : 'N/A');
    $newActivity->save();

    // Disparamos el evento para abrir la nueva pestaña con los datos frescos
    

    Alert::success('Proforma', 'Proforma generada exitosamente');
    // 1. Limpiamos los productos de la proforma y los campos para dejar la vista en blanco
    $this->detailProduct = [];
    $this->total = 0;
    $this->totalPagado = 0;
    $this->client_id = null;
    $this->search_client = '';

    // 2. Disparamos la descarga
    $this->dispatch('descargarPdf');
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



}

