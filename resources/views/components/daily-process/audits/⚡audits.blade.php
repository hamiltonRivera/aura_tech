<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div>
    <!-- Fila de Búsqueda (Fecha) -->
    <div class="mb-6">
        @include('livewire.daily-process.audits.search')
    </div>

    <!-- Títulos de las Secciones -->
    <div class="lg:grid grid-cols-4 sm:grid-col-1 gap-4 mb-2 px-3">
        <!-- Título para las dos primeras columnas (Ventas) -->
        <div class="col-span-2">
            <h2 class="text-lg font-bold text-gray-800 border-b-2 border-gray-200 pb-1 w-full text-center">Ventas</h2>
        </div>
        
        <!-- Título para las dos últimas columnas (Caja) -->
        <div class="col-span-2">
            <h2 class="text-lg font-bold text-gray-800 border-b-2 border-blue-500 pb-1 w-full text-center underline">Caja</h2>
        </div>
    </div>

    <!-- Contenido de los datos (Tus includes originales) -->
    <div class="lg:grid grid-cols-4 sm:grid-col-1 gap-4">
        
        {{-- primer columna (Cantidades de Ventas) --}}
        <div>
            @include('components.daily-process.audits.sales.first')
        </div>

        {{-- segunda columna (Montos de Ventas) --}}
        <div>
            @include('components.daily-process.audits.sales.second')
        </div>

        {{-- tercer columna (Apertura de Caja) --}}
        <div>
            @include('components.daily-process.audits.cashier.first')
        </div>

        {{-- cuarta columna (Cierre de Caja) --}}
        <div>
            @include('components.daily-process.audits.cashier.second')
        </div>
    </div>
</div>