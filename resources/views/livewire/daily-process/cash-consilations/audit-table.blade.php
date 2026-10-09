<div class="relative overflow-x-auto shadow-md rounded-lg">
    <table class="table w-full">
        <thead class="table-thead bg-blue-600 text-white">
            <tr>
                <th scope="col" class="px-6 py-3 text-left">No de Factura</th>
                <th scope="col" class="px-6 py-3 text-left">Monto</th>
                <th scope="col" class="px-6 py-3 text-left">Hora</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($ventas as $venta)
                <tr class="bg-white border-b hover:bg-gray-50 text-left text-sm">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $venta->numFactura }}</td>
                    <td class="px-6 py-4 font-semibold text-gray-700">C$ {{ number_format($venta->totalPagado, 2) }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $venta->created_at->format('h:i A') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">No hay ventas en efectivo registradas para esta fecha.</td>
                </tr>
            @endforelse
        </tbody>

        <!-- Fila de Total Acumulado -->
        <tfoot class="bg-gray-100 border-t-2 border-gray-300 font-bold text-gray-900">
            <tr>
                <td class="px-6 py-3 text-left uppercase tracking-wider text-sm">Total Efectivo</td>
                <td class="px-6 py-3 text-left text-base text-blue-600 font-extrabold">C$ {{ number_format($total_efectivo, 2) }}</td>
                <td class="px-6 py-3"></td>
            </tr>
        </tfoot>
    </table>

    <!-- Paginación limpia sin clases disabled -->
    <div class="p-4 bg-white border-t">
        {{ $ventas->links() }}
    </div>
</div>