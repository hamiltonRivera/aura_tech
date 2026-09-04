<x-app-layout>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Procesos Diarios') }}
        </h2>
    </x-slot>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="py-12">
            <div class="max sm:px-6 lg:px-8 mb-2">
                <div>
                    {{-- primer flex --}}
                    <div class="flex">
                        {{-- primer fila --}}
                        <div class="ml-3 mr-2 mb-2">
                            <a href="{{ route('products') }}" class="boton-azul"><i class="fa-solid fa-boxes-stacked"></i>
                                Inventario Productos</a>
                        </div>
                        {{-- segunda fila --}}
                        <div class="ml-2 mr-2 mb-2"><a href="{{ route('clients') }}" class="boton-azul"><i
                                    class="fa-solid fa-users"></i> Clientes</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="max sm:px-6 lg:px-8 mt-2 mb-2">
                <div>
                    {{-- primer flex --}}
                    <div class="flex">
                        {{-- primer fila --}}
                        <div class="ml-3 mr-2 mb-2">
                            <a href="{{ route('providers') }}" class="boton-azul"><i
                                    class="fa-solid fa-people-arrows"></i> Proveedores</a>
                        </div>
                        {{-- segunda fila --}}
                        <div class="ml-2 mr-2 mb-2">
                            <a href="{{ route('orders') }}" class="boton-azul"><i class="fa-solid fa-note-sticky"></i>
                                Ordenes a proveedores</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="max sm:px-6 lg:px-8 mt-2 mb-2">
                <div>
                    {{-- primer flex --}}
                    <div class="flex">
                        {{-- primer fila --}}
                        <div class="ml-3 mr-2 mb-2">
                            <a href="{{ route('expenses') }}" class="boton-azul"><i class="fa-solid fa-money-bill"></i>
                                Gastos</a>
                        </div>
                        {{-- segunda fila --}}
                        <div class="ml-2 mr-2 mb-2">
                            <a href="{{ route('reports') }}" class="boton-azul"><i class="fa-solid fa-file-pdf"></i>
                                Reportes</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="max sm:px-6 lg:px-8 mt-2 mb-2">
                <div>
                    {{-- primer flex --}}
                    <div class="flex">
                        {{-- primer fila --}}
                        <div class="ml-3 mr-2 mb-2">
                            <a href="{{ route('exchange_rate') }}" class="boton-azul"><i class="fa-solid fa-coins"></i>
                                Tasa de cambio</a>
                        </div>
                        {{-- segunda fila --}}
                        <div class="ml-2 mr-2 mb-2">
                            <a href="{{ route('products_most_sold') }}" class="boton-azul"><i
                                    class="fa-solid fa-boxes-stacked"></i> Productos más vendidos</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="max sm:px-6 lg:px-8 mt-2 mb-2">
                <div>
                    {{-- primer flex --}}
                    <div class="flex">
                        {{-- primer fila --}}
                        <div class="ml-3 mr-2 mb-2">
                          <a href="{{ route('combos') }}" class="boton-azul"><i class="fa-solid fa-book-open"></i> Combos</a>   
                        </div>
                        <div class="ml-3 mr-2 mb-2">
                            <a href="{{ route('sales_done_by_month') }}" class="boton-azul"><i class="fa-solid fa-eye"></i> Ver ventas realizadas X mes</a>
                        </div>

                    </div>
                </div>
            </div>

            <div class="max sm:px-6 lg:px-8 mt-2 mb-2">
                <div>
                    {{-- primer flex --}}
                    <div class="flex">
                        {{-- primer fila --}}
                        <div class="ml-3 mr-2 mb-2">
                            <a href="{{ route('salesDone') }}" class="boton-azul"><i class="fa-solid fa-eye"></i>Ver ventas realizadas totales</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
