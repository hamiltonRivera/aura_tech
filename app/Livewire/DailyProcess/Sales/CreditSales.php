<?php

namespace App\Livewire\DailyProcess\Sales;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\HistorialFactura;
use App\Models\ActivityLog;
use RealRashid\SweetAlert\Facades\Alert;
use Livewire\WithPagination;
use App\Models\Cambio;
use App\Models\Setting;
use App\Models\Product;
use App\Models\Client;
use App\Models\CreditSale;
use App\Models\CreditDetail;
use App\Models\ProductSale;
use App\Models\CreditPayment;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
class CreditSales extends Component
{

    use WithPagination;

    public $search_product = '', $search_client = '';
    public $dateError = null;


     public $interests = [
        '5%',
        '10%',
        '15%',
        '20%'
    ];

    //campos de la tabla credit_sales
    public $client_id,$date,$voucher_number, $total_debt, $user_id, $outstanding_balance, $status, $due_date, $days_overdue;

    //campos para el detalle de la venta
    public $product_id, $credit_sale_id, $price, $quantity, $total, $interest_id, $credit_price;
    protected $listeners = ['eliminarRegistro' => 'destroy'];

    public $productSel, $exchangeRate;
    public $detailProduct = [];


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

        $facturaDisponible = Setting::pluck('consecutivo');
        $this->voucher_number = $facturaDisponible->implode(',') + 1;

        $this->date = now()->format('Y-m-d');
        return view('livewire.daily-process.sales.credit-sales', compact('clients', 'products', 'facturaDisponible'));
    }

    public function refresh()
    {
        return redirect('/private/credit-sales');
    }

    public function buscarProducto()
    {

        $this->productSel = Product::whereAny(['codigo', 'descripcion'], 'like', '%' . $this->search_product . '%')->first();

        if ($this->productSel) {
            $this->quantity = 1;
            $this->price = floatval($this->productSel->precio_venta_unidad);
            $this->applyInterest();

            if ($this->productSel->stock <= 0) {
                session()->flash('producto', '*El producto seleccionado no tiene stock disponible.');
                // ❌ ya no lo reseteamos a null
            }
        } else {
            session()->flash('producto', '*El producto digitado no existe o es incorrecto.');
        }
    }

    public function applyInterest()
    {
        if (!$this->price) {
            $this->credit_price = null;
            return;
        }

        if (!$this->interest_id) {
            $this->credit_price = $this->price;
            return;
        }

        // Convierte '5%' -> 5.0
        $rate = (float) str_replace('%', '', $this->interest_id);
        $interestAmount = round($this->price * ($rate / 100), 2);
        $this->credit_price = round($this->price + $interestAmount, 2);
    }

    public function updatedInterestId()
    {
        $this->applyInterest();
        $this->calcular();
    }

    public function clearFields()
    {
        $this->search_product = '';
        $this->productSel = null;
        $this->quantity = null;
        $this->price = null;
        $this->total = null;
        $this->credit_price = null;
        $this->interest_id = null;
    }

    public function historial()
    {
        $historial = new HistorialFactura();
        //condicional que si el total a pagar es con intereses o no
        if ($this->interest_id) {
            $historial->monto = $this->updatedInterestId();
        } else {
            $historial->monto = $this->total_debt;
        }
        $historial->numFactura = $this->voucher_number;
        $historial->fecha = $this->date;

        $historial->descripcion = "Nuevo Registro - Venta al crédito Realizada";
        $historial->client_id = $this->client_id;
        $historial->user_id = auth()->user()->id;
        $historial->metodoPago = "Crédito";
        $historial->save();
    }

    public function calcular()
    {
        // Si no hay producto seleccionado, no calculamos nada
        if (!$this->productSel) {
            return $this->total_debt = 0;
        }

        // Verifica si la cantidad es 0, si lo es le asigna 1
        if (!$this->quantity) $this->quantity = 1;

        //  Validación: cantidad no puede ser mayor al stock
        if ($this->quantity > $this->productSel->stock) {
            session()->flash('cantidad', '*La cantidad digitada no puede ser mayor al stock disponible.');
            $this->quantity = $this->productSel->stock; // ajustamos al máximo permitido
        }

        // Validación: cantidad no puede ser negativa
        if ($this->quantity < 1) {
            session()->flash('cantidad', '*La cantidad digitada no puede ser menor a 1.');
            $this->quantity = 1;
        }

        //  Calculamos el total usando precio con interés si está disponible
        $basePrice = $this->credit_price ?? $this->price;
        $this->total_debt = round($basePrice * $this->quantity, 2);
    }

    // Retorna el precio con interés si fue aplicado, sino el precio original
    public function getPrecio()
    {
        return $this->credit_price ?? $this->price;
    }

    // Agrega el producto al carrito aplicando el interés si fue seleccionado
    public function addItem($array)
    {
        if ($this->productSel == null) {
            session()->flash('addItem', '*Campos Vacíos. Agrega un producto primero.');
            return false;
        }

        if (!$this->interest_id || !in_array($this->interest_id, $this->interests, true)) {
            session()->flash('addItem', '*Debes seleccionar un interés válido (5%, 10%, 15% o 20%) antes de agregar a la cesta.');
            return false;
        }

        $this->applyInterest();

        $datos = [
            "id"           => $this->productSel->id,
            "descripcion"  => $this->productSel->descripcion,
            "precio_venta" => $this->getPrecio(),
            "cantidad"     => $this->quantity,
            "total"        => round($this->getPrecio() * $this->quantity, 2),
        ];

        $indexBuscar = array_search($this->productSel->id, array_column($this->detailProduct, 'id'));

        // Si el producto ya está en la cesta, suma las cantidades
        if ($indexBuscar !== false) {
            $this->detailProduct[$indexBuscar]['cantidad'] += $this->quantity;
            $this->detailProduct[$indexBuscar]['total'] = round(
                $this->detailProduct[$indexBuscar]['cantidad'] * $this->getPrecio(), 2
            );
        } else {
            array_push($this->detailProduct, $datos);
        }

        $this->clearFields();

        // Suma todos los subtotales del carrito
        $this->total = array_reduce($this->detailProduct, fn($acc, $arr) => $acc + $arr['total'], 0);
        $this->total_debt = round($this->total, 2);
    }

    // Elimina un producto del carrito y recalcula el total
    public function destroy($key)
    {
        array_splice($this->detailProduct, $key, 1);

        $this->total = array_reduce($this->detailProduct, fn($acc, $arr) => $acc + $arr['total'], 0);
        $this->total_debt = round($this->total, 2);
    }

    public function getPaymentTermDays()
    {
        if ($this->date && $this->due_date) {
            try {
                return \Carbon\Carbon::parse($this->date)->diffInDays(\Carbon\Carbon::parse($this->due_date));
            } catch (\Exception $e) {
                return null;
            }
        }
        return null;
    }
    public function updatedDueDate($value)
    {
        if ($this->due_date) {
            $today = \Carbon\Carbon::today();
            $selected = \Carbon\Carbon::parse($this->due_date);
                if ($selected->lessThanOrEqualTo($today)) {
                    session()->flash('dateError', 'No se puede escoger una fecha igual o anterior a la de hoy.');
                     $this->days_overdue = null;
                }
            }
    }

       public function updated($propertyName)
    {
        if (in_array($propertyName, ['date', 'due_date'])) {
            $days = $this->getPaymentTermDays();
            if ($days !== null) {
                $this->days_overdue = $days;
            } else {
                $this->days_overdue = null;
            }
        }
    }

    public function store()
    {
        // Validación: no permitir venta si el carrito está vacío
        if (empty($this->detailProduct)) {
            // Siempre mostrar el mensaje en la vista Livewire
            session()->flash('error', 'Debe agregar productos a la cesta antes de realizar la venta.');
            // Opcional: también mostrar SweetAlert si está disponible
            if (class_exists('RealRashid\SweetAlert\Facades\Alert')) {
                Alert::error('Error', 'Debe agregar productos a la cesta antes de realizar la venta.');
            }
            return;
        }

        $newCreditSale = new CreditSale();
        $newCreditSale->client_id = $this->client_id;
        $newCreditSale->date = $this->date;
        $newCreditSale->voucher_number = $this->voucher_number;
        $newCreditSale->total_debt = $this->total_debt;
        $newCreditSale->user_id = auth()->user()->id;
        $newCreditSale->outstanding_balance = $this->total_debt;
        $newCreditSale->status = 'Activo';
        $newCreditSale->due_date = $this->due_date;
        $newCreditSale->days_overdue = $this->days_overdue;
        $newCreditSale->save();

        //historial de factura
        $this->historial();

        //añade el numero de factura al consecutivo
        $setting = Setting::query()->first();
        $setting->consecutivo = $this->voucher_number;
        $setting->save();

        //itera los productos del carrito
        foreach ($this->detailProduct as $product) {
            $detail = new CreditDetail();
            $detail->credit_sale_id = $newCreditSale->id;
            $detail->product_id = $product['id'];
            $detail->price = $product['precio_venta'];
            $detail->quantity = $product['cantidad'];
            $detail->total = $product['total'];
            $detail->save();

            // Resta el stock del producto
            $stock = Product::query()->find($product['id']);
            $stock->stock = $stock->stock - $product['cantidad'];
            $stock->save();

            //registro de actividad
            $newActivity = new ActivityLog();
            $newActivity->user_id = auth()->user()->id;
            $newActivity->activity = "Nuevo Registro - Venta Realizada al crédito";
            $newActivity->detail = "No Factura: " . $newCreditSale->voucher_number;
            $newActivity->save();

            // Registramos la venta del producto en `product_sales (productos mas vendidos)`
            $productoVenta = new ProductSale();
            $productoVenta->product_id = $product['id'];
            $productoVenta->quantity_sold = $product['cantidad'];
            $productoVenta->date = now(); // Puedes usar now()
            $productoVenta->save();

        }

        //algoritmo para imprimir voucher **importante*** solo para windows
        // ...existing code...

         Alert::success('Venta', 'Venta realizada exitosamente');
        $this->refresh();
   }
}

