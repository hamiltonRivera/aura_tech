<!-- Responsive Navigation Menu -->
<div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
    <div class="pt-2 pb-3 space-y-1">
        <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
        </x-responsive-nav-link>

        <!-- Administrador -->
        @can('administrador')
            <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase">
                Administrador
            </div>
            @include('layouts.mega-menu-items.admin')
        @endcan

        <!-- Procesos diarios / Ventas / etc. -->
        @can('procesos.diarios')
            <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase">
                Procesos Diarios y Ventas
            </div>
            @include('layouts.mega-menu-items.daily-process')
            @include('layouts.mega-menu-items.sales')
        @endcan

        @can('procesos.diarios')
            <x-responsive-nav-link href="{{ route('executive.dashboard') }}" :active="request()->routeIs('executive.dashboard')">
                Dashboard ejecutivo
            </x-responsive-nav-link>
        @endcan
    </div>

    <!-- Opciones de perfil y sesión (Responsive Settings Options) -->
    <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
        <!-- ... tu código existente de perfil y logout ... -->
    </div>
</div>