<div>
    <div class="relative overflow-x-auto">
        <table class="table min-w-full">
            <thead class="table-thead">
                <tr>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">#</th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">Proveedor</th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">Fecha</th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">Total Pagado</th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">Método Pago</th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                  <tr class="tr">
                    <td class="td whitespace-nowrap">{{ $loop->iteration }}) </td>
                    <td class="td whitespace-nowrap">{{ $order->provider->nombreApellido }} </td>
                    <td class="td whitespace-nowrap">{{ $order->fecha }} </td>
                    <td class="td whitespace-nowrap">{{ $order->totalPagado }}</td>
                    <td class="td whitespace-nowrap">{{ $order->metodoPago }}</td>
                    <td class="td whitespace-nowrap">
                        <a href="{{ route('detailOrders', $order->id) }}" class="boton-verde whitespace-nowrap" target="_blank">
                            <i class="fa-solid fa-eye"></i> Ver Detalles
                        </a>
                    </td>
                  </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="flex justify-left mt-4">
            <nav aria-label="Page navigation example">
              <ul class="flex list-style-none">
                <li class="page-item disabled">
                  {{ $orders->links() }}
                </li>
              </ul>
            </nav>
        </div>
    </div>
</div>
