

<div class="relative overflow-x-auto mr-5">
    <table class="table">
        <thead class="table-thead">
            <tr>
                <th scope="col" class="px-6 py-3">#</th>
                <th scope="col" class="px-6 py-3">Descripción</th>
                <th scope="col" class="px-6 py-3">Código</th>
                <th scope="col" class="px-6 py-3">Total Vendido</th>
                <th scope="col" class="px-6 py-3">Stock Actual</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
              <tr class="tr">
                <td class="td">{{ $loop->iteration }}) </td>
                <td class="td">{{ $product->descripcion }} </td>
                <td class="td">{{ $product->codigo }}</td>
                <td class="td">{{ $product->total_sold }}</td>
                <td class="td">{{ $product->stock }}</td>
              </tr>
            @endforeach

        </tbody>
    </table>
    <div class=" flex justify-left">
        <nav aria-label="Page navigation example">
          <ul class="flex list-style-none">
            <li class="page-item disabled ">
              {{ $products->links() }}
            </li>
          </ul>
        </nav>
      </div>
</div>
