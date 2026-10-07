<?php

use Livewire\Component;
use App\Models\User;
use App\Models\Sale;
use App\Models\DetailSale;
use App\Models\Product;
use App\Models\ActivityLog;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;
    public $search = '';
    
    public function with(): array
    {
        return [
            'sales' => Sale::with('user')
                ->orderBy('id', 'asc')
                ->where('numFactura', 'like', '%' . $this->search . '%')
                ->orWhereHas('user', function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                })
                ->paginate(10),
        ];
    }

    public function refresh()
    {
        return redirect('/private/admin/sales_to_cancel');
    }

    public function anularVenta($id)
    {
        $venta = Sale::find($id);

        if ($venta && $venta->status !== 'Anulada') {
            
            // 1. Devolver el stock al inventario
            $detalles = DetailSale::where('sale_id', $venta->id)->get();
            foreach ($detalles as $detalle) {
                $producto = Product::find($detalle->product_id);
                if ($producto) {
                    $producto->stock = $producto->stock + $detalle->cantidad;
                    $producto->save();
                }
            }

            // 2. Registrar la actividad en el log
            $newActivity = new ActivityLog();
            $newActivity->user_id = auth()->user()->id;
            $newActivity->activity = "Anulación de Factura";
            $newActivity->detail = "Se anuló la Factura No: " . $venta->numFactura;
            $newActivity->save();

            // 3. Cambiar estado y poner en 0 todos los montos para que no afecten los reportes
            $venta->estado = 'Anulada';
            $venta->totalPagado = 0;
            $venta->totalRecibido = 0;
            $venta->cambio = 0;
            $venta->mixed_cash_amount = 0;
            $venta->mixed_transfer_amount = 0;
            $venta->mixed_tarjeta_amount = 0;
            $venta->save();

            Alert::success('Anulada', 'La factura fue anulada y el inventario restaurado exitosamente.');
            
            // Redirigir para refrescar la vista y mostrar la alerta
            $this->refresh();
        }
    }
};
?>

<div>
      <div class="mb-3">
        @include('components.admin.sales-history-to-cancel.search')
      </div>
    
     <div class="mb-3">
        @include('components.admin.sales-history-to-cancel.table')
      </div>

</div>
