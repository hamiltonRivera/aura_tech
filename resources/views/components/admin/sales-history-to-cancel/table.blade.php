<div class="mt-4 overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-blue-600 text-left text-xs font-semibold text-white uppercase tracking-wider">
                    No. Factura
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-blue-600 text-left text-xs font-semibold text-white uppercase tracking-wider">
                    Fecha
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-blue-600 text-left text-xs font-semibold text-white uppercase tracking-wider">
                    Método
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-blue-600 text-left text-xs font-semibold text-white uppercase tracking-wider">
                    Total Pagado
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-blue-600 text-left text-xs font-semibold text-white uppercase tracking-wider">
                    Vendedor
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-blue-600 text-center text-xs font-semibold text-white uppercase tracking-wider">
                    Acción
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sales as $sale)
                <tr>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">{{ $sale->numFactura }}</p>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">{{ \Carbon\Carbon::parse($sale->fecha)->format('d/m/Y') }}</p>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">{{ $sale->metodoPago }}</p>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <p class="text-gray-900 whitespace-no-wrap font-bold">C$ {{ number_format($sale->totalPagado, 2) }}</p>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">{{ optional($sale->user)->name ?? 'N/A' }}</p>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                        @if($sale->estado !== 'Anulada')
                            <button wire:click="anularVenta({{ $sale->id }})" wire:confirm="¿Estás seguro de anular esta venta? Esta acción revertirá el inventario." class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-xs inline-flex items-center gap-2 justify-center">
                                <i class="fa-solid fa-trash"></i> Anular
                            </button>
                        @else
                            <span class="text-red-500 text-xs italic font-semibold">Anulada</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                        <p class="text-gray-500">No se encontraron facturas.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="px-5 py-3 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between">
        {{ $sales->links() }}
    </div>
</div>
