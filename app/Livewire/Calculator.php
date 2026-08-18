<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cambio;

class Calculator extends Component
{
    public $fecha, $total, $cantidad;

    public function render()
    {
        $this->fecha = now()->format('Y-m-d');
        return view('livewire.calculator');
    }

    public function calcular()
    {
        $tasaDelDiaSeleccionado = Cambio::whereDate('fecha', $this->fecha)->first();

        if ($tasaDelDiaSeleccionado && $this->cantidad) {
            $resultado = $tasaDelDiaSeleccionado->valor * $this->cantidad;
            $this->total = round($resultado, 2); // Número puro sin comas en el backend
        } else {
            $this->total = 0;
        }
    }
}
