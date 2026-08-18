<div class="relative overflow-x-auto">
    <table class="table">
        <thead class="table-thead">
            <tr>
                <th scope="col" class="px-6 py-3">#</th>
                <th scope="col" class="px-6 py-3"># Factura</th>
                <th scope="col" class="px-6 py-3">Fecha</th>
                <th scope="col" class="px-6 py-3">Cliente</th>
                <th scope="col" class="px-6 py-3">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
              <tr class="tr">
                <td class="td">{{ $loop->iteration }}) </td>
                <td class="td">{{ $sale->voucher_number }} </td>
                <td class="td">{{ $sale->date }} </td>
                <td class="td">{{ $sale->client->nombreApellido }}</td>
                <td class="td">
                  <a href="{{ route('credits_details_pdf', $sale->id) }}" class="boton-azul" target="_blank">
                    <i class="fa-solid fa-eye"></i> Imprimir Información
                  </a>
                </td>
              </tr>
            @endforeach

        </tbody>
    </table>
    <div class=" flex justify-left">
        <nav aria-label="Page navigation example">
          <ul class="flex list-style-none">
            <li class="page-item disabled ">
              {{ $sales->links() }}
            </li>
          </ul>
        </nav>
      </div>
</div>
