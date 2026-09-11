<x-app-layout>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Procesos Diarios') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Tarjeta Blanca Fija --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 sm:p-6">

                {{-- Grid Responsive: 1 columna en móvil, 2 en tablets, 3 en escritorio --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                    <a href="{{ route('products') }}" class="boton-azul flex items-center justify-center gap-2 w-full text-center py-2.5">
                        <i class="fa-solid fa-boxes-stacked"></i> Inventario Productos
                    </a>

                    <a href="{{ route('clients') }}" class="boton-azul flex items-center justify-center gap-2 w-full text-center py-2.5">
                        <i class="fa-solid fa-users"></i> Clientes
                    </a>


                    <a href="{{ route('expenses') }}" class="boton-azul flex items-center justify-center gap-2 w-full text-center py-2.5">
                        <i class="fa-solid fa-money-bill"></i> Gastos
                    </a>

                    <a href="{{ route('reports') }}" class="boton-azul flex items-center justify-center gap-2 w-full text-center py-2.5">
                        <i class="fa-solid fa-file-pdf"></i> Reportes
                    </a>

                    <a href="{{ route('exchange_rate') }}" class="boton-azul flex items-center justify-center gap-2 w-full text-center py-2.5">
                        <i class="fa-solid fa-coins"></i> Tasa de cambio
                    </a>

                    <a href="{{ route('products_most_sold') }}" class="boton-azul flex items-center justify-center gap-2 w-full text-center py-2.5">
                        <i class="fa-solid fa-boxes-stacked"></i> Productos más vendidos
                    </a>

                    <a href="{{ route('combos') }}" class="boton-azul flex items-center justify-center gap-2 w-full text-center py-2.5">
                        <i class="fa-solid fa-book-open"></i> Combos
                    </a>

                    <a href="{{ route('sales_done_by_month') }}" class="boton-azul flex items-center justify-center gap-2 w-full text-center py-2.5">
                        <i class="fa-solid fa-eye"></i> Ver ventas realizadas X mes
                    </a>

                    <a href="{{ route('salesDone') }}" class="boton-azul flex items-center justify-center gap-2 w-full text-center py-2.5">
                        <i class="fa-solid fa-eye"></i> Ver ventas realizadas totales
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
