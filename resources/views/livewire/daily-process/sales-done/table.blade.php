<div class="relative overflow-x-auto">
    <table class="table">
        <thead class="table-thead">
            <tr>
                <th scope="col" class="px-6 py-3">#</th>
                <th scope="col" class="px-6 py-3"># Factura</th>
                <th scope="col" class="px-6 py-3">Fecha</th>
                <th scope="col" class="px-6 py-3">Cliente</th>
                <th scope="col" class="px-6 py-3">Método Pago</th>
                <th scope="col" class="px-6 py-3">Total Pagado</th>
                <th scope="col" class="px-6 py-3">Realizado Por</th>
                <th scope="col" class="px-6 py-3">Estado</th>
                <th scope="col" class="px-6 py-3 text-center">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
              <tr class="tr">
                <td class="td">{{ $loop->iteration }}) </td>
                <td class="td">{{ $sale->numFactura }} </td>
                <td class="td">{{ $sale->fecha }} </td>
                <td class="td">{{ $sale->client->nombreApellido }}</td>
                <td class="td">{{ $sale->metodoPago }}</td>
                <td class="td">{{ $sale->totalPagado }}</td>
                <td class="td">{{ $sale->user->name }}</td>
                <td class="td">{{ $sale->status }}</td>
                <td class="td !px-2 whitespace-nowrap">
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-1.5">
                        <a href="{{ route('detailItems', $sale->id) }}" class="boton-azul inline-flex items-center gap-1 text-xs" target="_blank">
                            <i class="fa-solid fa-eye"></i> Ver Detalles
                        </a>
                        <a href="{{ route('reprint', $sale->id) }}" class="boton-lima inline-flex items-center gap-1 text-xs">
                            <i class="fa-solid fa-print"></i> Reimprimir
                        </a>
                    </div>
                </td>
              </tr>
            @endforeach
        </tbody>
    </table>
    <div class="flex justify-left">
        <nav aria-label="Page navigation example">
          <ul class="flex list-style-none">
            <li class="page-item disabled">
              {{ $sales->links() }}
            </li>
          </ul>
        </nav>
      </div>
</div>
