<div>
    <div class="pt-2 pb-3 space-y-1">
         @can('administrador')
            <x-responsive-nav-link href="{{ route('admin_panel') }}">
                <i class="fa-solid fa-user-tie"></i> {{ __('Panel Administrativo') }}
            </x-responsive-nav-link>
        @endcan
    </div>

    <div class="pt-2 pb-3 space-y-1">
        @can('procesos.diarios')
            <x-responsive-nav-link href="{{ route('processes') }}">
                <i class="fa-solid fa-bars"></i> {{ __('Procesos diarios') }}
            </x-responsive-nav-link>
        @endcan
    </div>

    <div class="pt-2 pb-3 space-y-1">
        @can('procesos.diarios')
            <x-responsive-nav-link href="{{ route('executive.dashboard') }}">
                <i class="fa-solid fa-chart-line"></i> {{ __('Dashboard Ejecutivo') }}
            </x-responsive-nav-link>
        @endcan
    </div>
</div>