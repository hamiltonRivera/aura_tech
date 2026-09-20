<div wire:poll.5s="loadData">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Ingresos de Hoy -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-500 rounded-full">
                    <i class="fas fa-dollar-sign text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Ingresos Hoy</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalSalesToday, 2) }} C$</p>
                </div>
            </div>
        </div>

        <!-- Ingresos del Mes -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-500 rounded-full">
                    <i class="fas fa-calendar-alt text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Ingresos del Mes</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalSalesThisMonth, 2) }} C$</p>
                </div>
            </div>
        </div>

        <!-- Ventas del Año -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-purple-500 rounded-full">
                    <i class="fas fa-chart-line text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Ventas del Año</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalSalesThisYear, 2) }} C$</p>
                </div>
            </div>
        </div>

        <!-- Total Clientes -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-500 rounded-full">
                    <i class="fas fa-users text-white"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Clientes</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalClients }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Productos Más Vendidos -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Productos Más Vendidos (30 días)</h3>
            <ul class="space-y-2">
                @forelse($topProducts as $product)
                    <li class="flex justify-between">
                        <span class="label_class">{{ $product->descripcion }}</span>
                        <span class="label_class">{{ $product->total_sold }}</span>
                    </li>
                @empty
                    <li class="text-gray-500">No hay datos disponibles</li>
                @endforelse
            </ul>
        </div>

        <!-- Alertas de Inventario -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Productos con Stock Bajo</h3>
            <ul class="space-y-2">
                @forelse($lowStockProducts as $product)
                    <li class="flex justify-between ">
                        <span class="label_class">{{ $product->descripcion }}</span>
                        <span class="text-red-600 font-semibold">Stock: {{ $product->stock }}</span>
                    </li>
                @empty
                    <li class="text-green-500">Todos los productos tienen stock suficiente</li>
                @endforelse
            </ul>
        </div>

        <!-- Productos Próximos a Vencer -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Productos Próximos a Vencer</h3>
            <ul class="space-y-2">
                @forelse($expiringProducts as $product)
                    <li class="flex justify-between">
                        <span>{{ $product->descripcion }}</span>
                        <span class="text-orange-600 font-semibold">Vence: {{ \Carbon\Carbon::parse($product->fecha_vencimiento)->format('d/m/Y') }}</span>
                    </li>
                @empty
                    <li class="text-green-500">No hay productos próximos a vencer</li>
                @endforelse
            </ul>
        </div>
    </div>

    <!-- Total Productos -->
    <div class="mt-6 bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-2 bg-indigo-500 rounded-full">
                <i class="fas fa-boxes text-white"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Productos en Inventario</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalProducts }}</p>
            </div>
        </div>
    </div>
</div>
