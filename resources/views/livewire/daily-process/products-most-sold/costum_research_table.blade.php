
{{-- @if ($costum_records)
<div class="relative overflow-x-auto mr-5">
    <table class="table">
        <thead class="table-thead">
            <tr>
                <th scope="col" class="px-6 py-3">#</th>
                <th scope="col" class="px-6 py-3">Descripción</th>
                <th scope="col" class="px-6 py-3">Fecha Vendido</th>
                <th scope="col" class="px-6 py-3">Cantidad Veces Vendido</th>
                <th scope="col" class="px-6 py-3">Stock Actual</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($costum_records as $product)
              <tr class="tr">
                <td class="td">{{ $loop->iteration }}) </td>
                <td class="td">{{ $product->product->descripcion }} </td>
                <td class="td">{{ $product->date }} </td>
                <td class="td">{{ $product->quantity_sold }}</td>
                <td class="td">{{ $product->product->stock }}</td>
              </tr>
            @endforeach

        </tbody>
    </table>
    <div class=" flex justify-left">
        <nav aria-label="Page navigation example">
          <ul class="flex list-style-none">
            <li class="page-item disabled ">
              {{ $costum_records->links() }}
            </li>
          </ul>
        </nav>
      </div>
</div>

@endif --}}
