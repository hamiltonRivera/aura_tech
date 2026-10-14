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
        $query = HistorialFactura::with(['user', 'client', 'sale']);

        // Si hay una fecha seleccionada, filtramos la tabla
        if (!empty($this->search)) {
            $query->whereDate('fecha', $this->search);
            
            // Calculamos el total solo si hay fecha
            $this->fecha_del_dia = HistorialFactura::whereDate('fecha', $this->search)->get();
            $this->monto_del_dia = $this->fecha_del_dia->sum('monto');
        } else {
            // Si el input está vacío, el total es 0
            $this->monto_del_dia = 0;
        }

        $histories = $query->paginate(10);

        return view('livewire.admin.vouchers-history.vouchers-history', compact('histories'));
    }
}
