<div class="relative overflow-x-auto">
    <table class="table">
        <thead class="table-thead">
            <tr>
                <th scope="col" class="px-6 py-3">No de Factura</th>
                <th scope="col" class="px-6 py-3">Monto</th>
                <th scope="col" class="px-6 py-3">Hora</th>
            </tr>
        </thead>
        <tbody>
           @forelse ($ventas as $venta)
    <tr class="bg-white border-b hover:bg-gray-50">
        <td class="px-6 py-4">{{ $venta->numFactura }}</td>
        <td class="px-6 py-4">C$ {{ number_format($venta->totalPagado, 2) }}</td>
        <td class="px-6 py-4">{{ $venta->created_at->format('h:i A') }}</td>
    </tr>
@empty
    <tr>
        <td colspan="3" class="px-6 py-4 text-center text-gray-500">No hay ventas en efectivo registradas para esta fecha.</td>
    </tr>
@endforelse

        </tbody>
    </table>
    <div class=" flex justify-left">
        <nav aria-label="Page navigation example">
          <ul class="flex list-style-none">
            <li class="page-item disabled ">
              {{ $ventas->links() }} 
            </li>
          </ul>
        </nav>
      </div>
</div>
