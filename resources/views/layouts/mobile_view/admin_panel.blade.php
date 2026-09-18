<x-app-layout>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <x-slot name="header">
       <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Panel Administrativo') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Tarjeta Blanca Fija --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 sm:p-6">
                
                {{-- Grid Responsive: 1 columna en móvil, 2 en tablets, 3 en escritorio --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                    <a href="{{ route('userscontrol') }}" class="boton-azul flex items-center justify-center gap-2 w-full text-center py-2.5">
                        <i class="fa-solid fa-users"></i> Control Usuarios
                    </a>

                    <a href="{{ route('categories') }}" class="boton-azul flex items-center justify-center gap-2 w-full text-center py-2.5">
                        <i class="fa-solid fa-boxes"></i> Categoría de productos
                    </a>

                    <a href="{{ route('providers') }}" class="boton-azul flex items-center justify-center gap-2 w-full text-center py-2.5">
                        <i class="fa-solid fa-people-arrows"></i> Proveedores
                    </a>

                    <a href="{{ route('orders') }}" class="boton-azul flex items-center justify-center gap-2 w-full text-center py-2.5">
                        <i class="fa-solid fa-note-sticky"></i> Órdenes a proveedores
                    </a>

                    <a href="{{ route('incomes_expenses') }}" class="boton-azul flex items-center justify-center gap-2 w-full text-center py-2.5">
                        <i class="fa-regular fa-money-bill-1"></i> Ingresos/Egresos
                    </a>

                    <a href="{{ route('voucherHistory') }}" class="boton-azul flex items-center justify-center gap-2 w-full text-center py-2.5">
                        <i class="fa-solid fa-clock"></i> Historial Facturas
                    </a>

                    <a href="{{ route('activity_log') }}" class="boton-azul flex items-center justify-center gap-2 w-full text-center py-2.5">
                        <i class="fa-solid fa-note-sticky"></i> Bitácora de actividades
                    </a>

                    <a href="{{ route('settings') }}" class="boton-azul flex items-center justify-center gap-2 w-full text-center py-2.5">
                        <i class="fa-solid fa-gear"></i> Ajustes de sistema
                    </a>

                    <a href="{{ route('discounts') }}" class="boton-azul flex items-center justify-center gap-2 w-full text-center py-2.5">
                        <i class="fa-solid fa-percent"></i> Descuentos
                    </a>

                    <a href="{{ route('payroll') }}" class="boton-azul flex items-center justify-center gap-2 w-full text-center py-2.5">
                        <i class="fa-solid fa-money-check-dollar"></i> Planilla
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
