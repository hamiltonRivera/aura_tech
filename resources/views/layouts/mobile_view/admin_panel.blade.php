<x-app-layout>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <x-slot name="header">
       <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Panel Administrativo') }}
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
                <a href="{{route('userscontrol')}}" class="boton-azul"><i class="fa-solid fa-users"></i> Control Usuarios</a>
               </div>
               {{-- segunda fila --}}
               <div class="ml-2 mr-2 mb-2">
                <a href="{{route('categories')}}" class="boton-azul"><i class="fa-solid fa-boxes"></i> Categoría de productos</a>
               </div>
             </div>
            </div>
        </div>

        <div class="max sm:px-6 lg:px-8 mt-2 mb-2">
            <div >
              {{-- primer flex --}}
             <div class="flex">
               {{-- primer fila --}}
               <div class="ml-3 mr-2 mb-2">
                <a href="{{route('providers')}}" class="boton-azul"><i class="fa-solid fa-people-arrows"></i>  Proveedores</a>
               </div>
               {{-- segunda fila --}}
               <div class="ml-2 mr-2 mb-2">
                <a href="{{route('orders')}}" class="boton-azul"><i class="fa-solid fa-note-sticky"></i>  Ordenes a proveedores</a>
               </div>
             </div>
            </div>
        </div>

        <div class="max sm:px-6 lg:px-8 mt-2 mb-2">
            <div >
              {{-- primer flex --}}
             <div class="flex">
               {{-- primer fila --}}
               <div class="ml-3 mr-2 mb-2">
                 <a href="{{route('incomes_expenses')}}" class="boton-azul"><i class="fa-regular fa-money-bill-1"></i> Ingresos/Egresos</a>
                </div>
               {{-- segunda fila --}}
               <div class="ml-2 mr-2 mb-2">
                 <a href="{{ route('voucherHistory') }}" class="boton-azul"><i class="fa-solid fa-clock"></i> Historial Facturas</a>
                </div>
             </div>
            </div>
        </div>

        <div class="max sm:px-6 lg:px-8 mt-2 mb-2">
            <div >
              {{-- primer flex --}}
             <div class="flex">
               {{-- primer fila --}}
               <div class="ml-3 mr-2 mb-2">
                 <a href="{{ route('activity_log') }}" class="boton-azul"><i class="fa-solid fa-note-sticky"></i> Bitacora de actividades</a>
                </div>
               {{-- segunda fila --}}
               <div class="ml-2 mr-2 mb-2">
                 <a href="{{ route('settings') }}" class="boton-azul"><i class="fa-solid fa-gear"></i> Ajustes de sistema</a>
                </div>
             </div>
            </div>
        </div>

        <div class="max sm:px-6 lg:px-8 mt-2 mb-2">
            <div>
              {{-- primer flex --}}
             <div class="flex">
               {{-- primer fila --}}
               <div class="ml-3 mr-2">
                 <a href="{{ route('discounts') }}" class="boton-azul"><i class="fa-solid fa-percent"></i> Descuentos</a> 
                </div>
               
               
             </div>
            </div>
        </div>
    </div>
     </div>
    
</x-app-layout>