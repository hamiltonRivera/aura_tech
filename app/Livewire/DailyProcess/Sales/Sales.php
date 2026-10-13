<?php

namespace App\Livewire\DailyProcess\Sales;

use Livewire\Component;
use App\Models\HistorialFactura;
use App\Models\ActivityLog;
use RealRashid\SweetAlert\Facades\Alert;
use Livewire\WithPagination;
use App\Models\Cambio;
use App\Models\Setting;
use App\Models\Product;
use App\Models\Client;
use App\Models\Sale;
use App\Models\DetailSale;
use App\Models\Discount;
use App\Models\ProductSale;
use App\Models\Combo;
use App\Models\ComboDetail;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use App\Events\SaleCreated;

class Sales extends Component
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
        'Transferencia Bancaria',
        'Mixto',
        'Tarjeta'
    ];

    // Variables para pago mixto y validación reactiva
    public $mixed_cash_amount = 0;
    public $mixed_transfer_amount = 0;
    public $tipo_mixto_secundario = 'Transferencia Bancaria';
    public $boton_deshabilitado = false;

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

        //algoritmo para recuperar la ultima factura disponible y le suma 1
        $facturaDisponible = Setting::pluck('consecutivo');
        $this->numFactura = $facturaDisponible->implode(',') + 1;

        $this->fecha = now()->format('Y-m-d');
        $this->descuentos = Discount::orderBy('id', 'asc')->get();
        return view('livewire.daily-process.sales.sales', compact('clients', 'products', 'facturaDisponible'));
    }

    public function refresh()
    {
        return redirect('/private/sales');
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
        $this->validarPagoMixto();
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

    public function historial()
    {
        $historial = new HistorialFactura();
        //condicional que si el total a pagar es con descuento o no
        if ($this->descuento) {
            $historial->monto = $this->totalPagadoDescuento;
        } else {
            $historial->monto = $this->totalPagado;
        }
        $historial->numFactura = $this->numFactura;
        $historial->fecha = $this->fecha;

        $historial->descripcion = "Nuevo Registro - Venta Realizada";
        $historial->client_id = $this->client_id;
        $historial->user_id = auth()->user()->id;
        $historial->metodoPago = $this->metodoPago;
        $historial->save();
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

    public function validarPagoMixto()
    {
        if ($this->metodoPago === 'Mixto') {
            $efectivo = $this->mixed_cash_amount === '' ? 0 : floatval($this->mixed_cash_amount);
            $transferencia = $this->mixed_transfer_amount === '' ? 0 : floatval($this->mixed_transfer_amount);

            $totalDigitado = round($efectivo + $transferencia, 2);
            $totalReal = round($this->descuento ? floatval($this->totalPagadoDescuento) : floatval($this->totalPagado), 2);

            if ($totalDigitado < $totalReal) {
                $this->addError('error_mixto', '* Faltan C$ ' . number_format($totalReal - $totalDigitado, 2) . ' para completar el pago.');
                $this->boton_deshabilitado = true;
            } elseif ($totalDigitado > $totalReal) {
                $this->addError('error_mixto', '* Te pasaste por C$ ' . number_format($totalDigitado - $totalReal, 2) . '. El monto debe ser exacto.');
                $this->boton_deshabilitado = true;
            } else {
                $this->resetErrorBag('error_mixto');
                $this->boton_deshabilitado = false;
            }
        } else {
            $this->resetErrorBag('error_mixto');
            $this->boton_deshabilitado = false;
        }
    }

    public function comprobarPago()
    {
        //Valida que el total recibido es menor a total a pagar
        if ($this->totalRecibido < $this->totalPagado) {
            session()->flash('message', '*El total recibido no puede ser menor al total a pagar.');
            $this->totalRecibido = $this->totalPagado;
            $this->cambio = 0;
            return false;
        }
    }

    public function comprobarPagoDescuento()
    {
        if ($this->totalRecibido < $this->totalPagadoDescuento) {
            session()->flash('message', '*El total recibido no puede ser menor al total a pagar.');
            $this->totalRecibido = $this->totalPagadoDescuento;
            $this->cambio = 0;
            return false;
        }
    }

    public function pagoTransferencia()
    {
        if (in_array($this->metodoPago, ['Transferencia Bancaria', 'Tarjeta', 'Mixto'])) {
            $this->totalRecibido = $this->descuento ? $this->totalPagadoDescuento : $this->totalPagado;
            $this->cambio = 0;
        }

        if ($this->metodoPago != 'Mixto') {
            $this->mixed_cash_amount = 0;
            $this->mixed_transfer_amount = 0;
        }

        $this->validarPagoMixto();
    }

    public function updated($field)
    {
        if ($field === 'totalRecibido' || $field === 'totalPagadoDescuento' || $field === 'totalPagado') {
            $this->cambio();
        }

        if (in_array($field, ['mixed_cash_amount', 'mixed_transfer_amount', 'metodoPago', 'tipo_mixto_secundario'])) {
            $this->validarPagoMixto();
        }
    }

    public function cambio()
    {
        //verifica si el cambio a dar es resultado de un descuento
        if ($this->descuento) {
            $this->cambio = round($this->totalRecibido - $this->totalPagadoDescuento, 2);
            $this->comprobarPagoDescuento();
        } else {
            $this->cambio = round($this->totalRecibido - $this->totalPagado, 2);
            $this->comprobarPago();
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
        $combo = Combo::whereRaw('TRIM(LOWER(description)) = ?', [$descripcionLimpia])->first();

        // Validaciones de stock originales...
        if ($combo) {
            $comboDetails = ComboDetail::where('combo_id', $combo->id)->get();
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
            $yaComprometido = $this->obtenerCantidadComprometidaEnCesta($this->productSel->id);
            $unidadesRequeridasTotal = $yaComprometido + $this->cantidad;
            if ($this->productSel->stock < $unidadesRequeridasTotal) {
                session()->flash('addItem', "*No hay stock suficiente para '{$this->productSel->descripcion}'. Stock real: {$this->productSel->stock}, ya en la cesta: {$yaComprometido}.");
                return false;
            }
        }

        // LÓGICA DE DESCUENTOS PARA EL ARRAY
        $precioUnitarioBase = $this->precio;
        $porcentajeDesc = 0;
        $montoDescuentoUnitario = 0;
        $precioFinalUnitario = $this->precio;

        if ($this->descuento_individual == "Si" && $this->descuento_i) {
            $porcentajeDesc = $this->descuento_i;
            $montoDescuentoUnitario = ($precioUnitarioBase * $porcentajeDesc) / 100;
            $precioFinalUnitario = round($precioUnitarioBase - $montoDescuentoUnitario, 2);
        }
        $montoDescuentoTotalItem = round($montoDescuentoUnitario * $this->cantidad, 2);

        $indexBuscar = array_search($this->productSel->id, array_column($this->detailProduct, 'id'));

        if ($indexBuscar !== false && !$combo) {
            $this->detailProduct[$indexBuscar]['cantidad'] += $this->cantidad;

            $descUnitario = ($this->detailProduct[$indexBuscar]['precio_venta'] * ($this->detailProduct[$indexBuscar]['descuento_porcentaje'] ?? 0)) / 100;
            $this->detailProduct[$indexBuscar]['descuento_monto'] = round($descUnitario * $this->detailProduct[$indexBuscar]['cantidad'], 2);
            $precioFinalArr = $this->detailProduct[$indexBuscar]['precio_venta'] - $descUnitario;
            $this->detailProduct[$indexBuscar]['total'] = round($this->detailProduct[$indexBuscar]['cantidad'] * $precioFinalArr, 2);
        } else {
            $datos = [
                "id" => $this->productSel->id,
                "descripcion" => $this->productSel->descripcion,
                "precio_venta" => $precioUnitarioBase,
                "cantidad" => $this->cantidad,
                "descuento_porcentaje" => $porcentajeDesc,
                "descuento_monto" => $montoDescuentoTotalItem,
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

        $this->validarPagoMixto();
    }


    public function store()
    {

        $this->validate([
            'numFactura' => 'required|numeric|unique:sales,numFactura',
            'fecha' => 'required|date',
            'client_id' => 'required',
            'descuento' => 'nullable|numeric',
            'totalPagado' => 'required|numeric',
            'cambio' => 'required|numeric',
            'totalRecibido' => 'required|numeric',
            'totalDescuento' => 'nullable|numeric',
            'totalPagadoDescuento' => 'nullable|numeric',
            'metodoPago' => 'required|string|in:Efectivo,Transferencia Bancaria,Mixto,Tarjeta'
        ]);

        // --- VALIDACIÓN ESTRICTA PAGO MIXTO ---
        if ($this->metodoPago === 'Mixto') {
            $this->validate([
                'mixed_cash_amount' => 'required|numeric|min:0',
                'mixed_transfer_amount' => 'required|numeric|min:0',
            ]);

            $totalDigitado = round(floatval($this->mixed_cash_amount) + floatval($this->mixed_transfer_amount), 2);
            $totalReal = round($this->descuento ? floatval($this->totalPagadoDescuento) : floatval($this->totalPagado), 2);

            if ($totalDigitado !== $totalReal) {
                $this->addError('error_mixto', 'La suma del efectivo y la transferencia no coincide con el total a pagar. Monto ingresado: C$ ' . number_format($totalDigitado, 2) . ' / Total real: C$ ' . number_format($totalReal, 2));
                return; // Detiene la ejecución
            }
        }

        $newventa = new Sale();
        $newventa->client_id = $this->client_id;
        $newventa->descuento = $this->descuento;
        $newventa->numFactura = $this->numFactura;
        $newventa->fecha = $this->fecha;
        $newventa->totalPagado = $this->totalPagado;
        $newventa->cambio = $this->cambio;
        $newventa->totalRecibido = $this->totalRecibido;
        $newventa->totalDescuento = $this->totalDescuento;
        $newventa->totalPagadoDescuento = $this->totalPagadoDescuento;
        $newventa->user_id = auth()->user()->id;
        $newventa->metodoPago = $this->metodoPago;

        // Guardar montos mixtos evaluando si eligió Tarjeta o Transferencia
        if ($this->metodoPago === 'Mixto') {
            $newventa->mixed_cash_amount = $this->mixed_cash_amount;
            
            if ($this->tipo_mixto_secundario === 'Tarjeta') {
                $newventa->mixed_transfer_amount = null;
                $newventa->mixed_tarjeta_amount = floatval($this->mixed_transfer_amount); 
            } else {
                $newventa->mixed_transfer_amount = floatval($this->mixed_transfer_amount);
                $newventa->mixed_tarjeta_amount = null; 
            }
        } else {
            $newventa->mixed_cash_amount = null;
            $newventa->mixed_transfer_amount = null;
            $newventa->mixed_tarjeta_amount = null;
        }

        $newventa->save();

        event(new SaleCreated());
        $this->historial();

        $setting = Setting::first();
        $setting->consecutivo = $this->numFactura;
        $setting->save();

        // 1. CLONAMOS Y PREPARAMOS EL ARRAY PARA EL PDF (Con descuento global si aplica)
        $detallesParaPDF = $this->detailProduct;
        if (!empty($this->descuento) && is_numeric($this->descuento) && $this->descuento > 0) {
            foreach ($detallesParaPDF as $key => $item) {
                if (empty($item['descuento_porcentaje']) || $item['descuento_porcentaje'] == 0) {
                    $precioBase = $item['precio_venta'];
                    $porcentajeGlobal = floatval($this->descuento);
                    $montoDescontadoUnitario = ($precioBase * $porcentajeGlobal) / 100;

                    $detallesParaPDF[$key]['descuento_porcentaje'] = $porcentajeGlobal;
                    $detallesParaPDF[$key]['descuento_monto'] = round($montoDescontadoUnitario * $item['cantidad'], 2);
                    $detallesParaPDF[$key]['total'] = round(($precioBase - $montoDescontadoUnitario) * $item['cantidad'], 2);
                }
            }
        }

        // 2. GUARDAMOS EN BASE DE DATOS USANDO EL ARRAY PROCESADO ($detallesParaPDF)
        // Usamos este array para que en DetailSale quede guardado el precio final real de la venta.
        foreach ($detallesParaPDF as $item) {
            $detaProduc = new DetailSale();
            $detaProduc->product_id = $item['id'];
            $detaProduc->sale_id = $newventa->id;
            // Para la BD, queremos que el precio unitario refleje el costo YA rebajado para que el total cuadre
            $precioYaRebajado = $item['precio_venta'] - (($item['descuento_monto'] ?? 0) / $item['cantidad']);
            $detaProduc->precio = $precioYaRebajado;
            $detaProduc->cantidad = $item['cantidad'];
            $detaProduc->total = $item['total'];
            $detaProduc->save();

            $productModel = Product::find($item['id']);
            if ($productModel) {
                $productModel->stock = $productModel->stock - $item['cantidad'];
                $productModel->save();

                $descripcionLimpia = trim(strtolower($productModel->descripcion));
                $combo = \App\Models\Combo::whereRaw('TRIM(LOWER(description)) = ?', [$descripcionLimpia])->first();

                if ($combo) {
                    $comboDetails = \App\Models\ComboDetail::where('combo_id', $combo->id)->get();
                    foreach ($comboDetails as $detail) {
                        $componentProduct = Product::find($detail->product_id);
                        if ($componentProduct) {
                            $quantityToDeduct = $detail->quantity * $item['cantidad'];
                            $componentProduct->stock = $componentProduct->stock - $quantityToDeduct;
                            $componentProduct->save();
                        }
                    }
                }
            }

            $newActivity = new ActivityLog();
            $newActivity->user_id = auth()->user()->id;
            $newActivity->activity = "Nuevo Registro - Venta Realizada";
            $newActivity->detail = "No Factura: " . $newventa->numFactura;
            $newActivity->save();

            $productoVenta = new ProductSale();
            $productoVenta->product_id = $item['id'];
            $productoVenta->quantity_sold = $item['cantidad'];
            $productoVenta->date = now();
            $productoVenta->save();
        }

        $clientObj = Client::find($this->client_id);
        $nombreCliente = $clientObj ? $clientObj->nombreApellido : 'Cliente General';
        $totalFinalVenta = $this->descuento ? $this->totalPagadoDescuento : $this->totalPagado;

        // 3. PASAMOS EL ARRAY CON LAS NUEVAS COLUMNAS AL PDF
        session()->forget('ventaData');
        session([
            'ventaData' => [
                'numFactura'  => $this->numFactura,
                'cliente'     => $nombreCliente,
                'fecha'       => $this->fecha,
                'detalles'    => $detallesParaPDF, // El array con montos de descuento
                'totalPagado' => $totalFinalVenta
            ]
        ]);
        session()->save();

        $this->detailProduct = [];
        $this->total = 0;
        $this->totalPagado = 0;
        $this->client_id = null;
        $this->search_client = '';
        $this->search_product = '';
        $this->productSel = null;
        $this->descuento = null;
        $this->totalRecibido = null;
        $this->cambio = null;

        // Reset variables mixtas
        $this->mixed_cash_amount = 0;
        $this->mixed_transfer_amount = 0;
        $this->tipo_mixto_secundario = 'Transferencia Bancaria';
        $this->boton_deshabilitado = false;

        Alert::success('Venta', 'Venta realizada exitosamente');

        $this->dispatch('abrir-pdf', url: route('venta.pdf'));
    }

    public function decrementarCantidad($key)
    {
        if (isset($this->detailProduct[$key])) {
            if ($this->detailProduct[$key]['cantidad'] > 1) {
                $this->detailProduct[$key]['cantidad']--;

                $precioUnitario = $this->detailProduct[$key]['precio_venta'];
                $porcentaje = $this->detailProduct[$key]['descuento_porcentaje'] ?? 0;

                $descUnitario = ($precioUnitario * $porcentaje) / 100;
                $precioFinalUnit = $precioUnitario - $descUnitario;

                $this->detailProduct[$key]['descuento_monto'] = round($descUnitario * $this->detailProduct[$key]['cantidad'], 2);
                $this->detailProduct[$key]['total'] = round($precioFinalUnit * $this->detailProduct[$key]['cantidad'], 2);

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
        } else {
            $this->validarPagoMixto();
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

    public function incrementarCantidad($key)
    {
        if (isset($this->detailProduct[$key])) {
            $product = Product::find($this->detailProduct[$key]['id']);
            if ($product && $this->detailProduct[$key]['cantidad'] < $product->stock) {
                $this->detailProduct[$key]['cantidad']++;

                $precioUnitario = $this->detailProduct[$key]['precio_venta'];
                $porcentaje = $this->detailProduct[$key]['descuento_porcentaje'] ?? 0;

                $descUnitario = ($precioUnitario * $porcentaje) / 100;
                $precioFinalUnit = $precioUnitario - $descUnitario;

                $this->detailProduct[$key]['descuento_monto'] = round($descUnitario * $this->detailProduct[$key]['cantidad'], 2);
                $this->detailProduct[$key]['total'] = round($precioFinalUnit * $this->detailProduct[$key]['cantidad'], 2);

                $this->recalcularTotales();
            } else {
                session()->flash('addItem', '*No hay más stock disponible para este producto.');
            }
        }
    }
}