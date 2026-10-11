<div class="relative overflow-x-auto bg-white rounded-lg shadow">
    <table class="table min-w-full text-sm text-left">
        <thead class="table-thead bg-blue-600 text-white uppercase text-xs">
            <tr>
                <th scope="col" class="px-4 py-3">#</th>
                <th scope="col" class="px-4 py-3 whitespace-nowrap"># Factura</th>
                <th scope="col" class="px-4 py-3 whitespace-nowrap">Fecha</th>
                <th scope="col" class="px-4 py-3">Cliente</th>
                <th scope="col" class="px-4 py-3 whitespace-nowrap">Método Pago</th>
                <th scope="col" class="px-4 py-3 whitespace-nowrap">Total Pagado</th>
                <th scope="col" class="px-4 py-3 whitespace-nowrap">Realizado Por</th>
                <th scope="col" class="px-4 py-3 text-center">Estado</th>
                <th scope="col" class="px-4 py-3">Justificación</th>
                <th scope="col" class="px-4 py-3 text-center whitespace-nowrap">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
              <tr class="tr border-b hover:bg-gray-50">
                <td class="td px-4 py-3 font-medium">{{ $loop->iteration }})</td>
                <td class="td px-4 py-3 font-semibold">{{ $sale->numFactura }}</td>
                <td class="td px-4 py-3 whitespace-nowrap text-xs text-gray-600">
                    {{ \Carbon\Carbon::parse($sale->fecha)->format('d/m/Y H:i') }}
                </td>
                <td class="td px-4 py-3">{{ optional($sale->client)->nombreApellido ?? 'Cliente Default' }}</td>
                <td class="td px-4 py-3 whitespace-nowrap">{{ $sale->metodoPago }}</td>
                <td class="td px-4 py-3 whitespace-nowrap font-bold">
                    C$ {{ number_format($sale->totalPagado, 2) }}
                </td>
                <td class="td px-4 py-3 text-xs">{{ optional($sale->user)->name ?? 'N/A' }}</td>
                <td class="td px-4 py-3 text-center whitespace-nowrap">
                    @if($sale->status === 'Anulada')
                        <span class="px-2 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">Anulada</span>
                    @else
                        <span class="px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Activa</span>
                    @endif
                </td>
                <td class="td px-4 py-3 text-xs max-w-xs truncate" title="{{ $sale->justification }}">
                    @if($sale->justification)
                        <span class="text-red-600 italic font-medium">{{ $sale->justification }}</span>
                    @else
                        <span class="text-gray-400 italic">N/A</span>
                    @endif
                </td>
                <td class="td px-4 py-3">
                    <div class="flex items-center justify-center gap-2 whitespace-nowrap">
                        <a href="{{ route('detailItems', $sale->id) }}" class="boton-azul inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded transition" target="_blank">
                            <i class="fa-solid fa-eye"></i> Ver Detalles
                        </a>
                        <a href="{{ route('reprint', $sale->id) }}" class="boton-lima inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-medium text-white bg-lime-600 hover:bg-lime-700 rounded transition">
                            <i class="fa-solid fa-print"></i> Reimprimir
                        </a>
                    </div>
                </td>
              </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Paginación -->
    <div class="p-4 bg-white border-t">
        {{ $sales->links() }}
    </div>
</div>