<?php

namespace App\Livewire\Admin\VouchersHistory;

use Livewire\Component;
use App\Models\HistorialFactura;
use Livewire\WithPagination;

class VouchersHistory extends Component
{
    use WithPagination;
    
    public $search = '';
    public $cantidad_seleccionada, $monto_del_dia = 0, $fecha_del_dia;

    public function render()
    {
        $busqueda = '%' . $this->search . '%';
        
        // Agregamos 'sale' al eager loading
        $histories = HistorialFactura::with(['user', 'client', 'sale'])
         ->where(function($query) use ($busqueda) {
             $query->whereRelation('user', 'name', 'like', $busqueda)
                   ->orWhereRelation('client', 'nombreApellido', 'like', $busqueda)
                   ->orWhere('numFactura', 'like', $busqueda)
                   ->orWhere('fecha', 'like', $busqueda)
                   ->orWhere('descripcion', 'like', $busqueda)
                   ->orWhere('metodoPago', 'like', $busqueda);
         })
         ->paginate(10);

         // recupera la fecha que digite y suma el total de todo el dia
         $this->fecha_del_dia = HistorialFactura::whereFecha($this->search)->get();
         $this->monto_del_dia = $this->fecha_del_dia->sum('monto');
         
        return view('livewire.admin.vouchers-history.vouchers-history', compact('histories'));
    }
}
