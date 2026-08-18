<nav class="bg-white border-gray-200 dark:bg-gray-900 rounded-md">
    @can('administrador')
    <div>
        @include('layouts.mega-menu-items.admin')
    </div>
    @endcan
</nav>

<nav class="bg-white border-gray-200 dark:bg-gray-900 rounded-md">
    <div>
        @can('procesos.diarios')
        @include('layouts.mega-menu-items.daily-process')
        @endcan
    </div>
</nav>

<nav class="bg-white border-gray-200 dark:bg-gray-900 rounded-md">
    <div>
        @can('procesos.diarios')
        @include('layouts.mega-menu-items.sales')
        @endcan

    </div>
</nav>


<nav class="bg-white border-gray-200 dark:bg-gray-900 rounded-md">
    <div>
        @can('procesos.diarios')
        <div class="flex flex-wrap items-center justify-between max-w-screen-xl mx-auto p-4">

            <a href="{{ route('executive.dashboard') }}" class="menu-ventas">Dashboard ejecutivo</a>
        </div>
        @endcan
    </div>
</nav>
