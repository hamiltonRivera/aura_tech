

<div class="relative overflow-x-auto mr-5">
    <table class="table">
        <thead class="table-thead">
            <tr>
                <th scope="col" class="px-6 py-3">#</th>
                <th scope="col" class="px-6 py-3">Descripción</th>
                <th scope="col" class="px-6 py-3">Fecha</th>
                <th scope="col" class="px-6 py-3">Monto</th>
                <th scope="col" class="px-6 py-3">Tipo de gasto</th>
                <th scope="col" class="px-6 py-3">Salió de caja</th>
                <th scope="col" class="px-6 py-3">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($expenses as $expense)
              <tr class="tr">
                <td class="td">{{ $loop->iteration }}) </td>
                <td class="td">{{ $expense->descripcion }} </td>
                <td class="td">{{ $expense->fecha }} </td>
                <td class="td">{{ $expense->monto }}</td>
                <td class="td">{{ $expense->tipo_gasto }}</td>
                <td class="td">{{ $expense->from_cash_register }}</td>
                <td class="td">
                    <button type="button" class="boton-azul" wire:click="edit({{ $expense->id }})">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>

                    <button type="button" class="boton-amarillo" onclick="confirmarEliminacion({{ $expense->id }})" wire:confirm="Seguro que deseas eliminar el registro?">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>
              </tr>
            @endforeach

        </tbody>
    </table>
    <div class=" flex justify-left">
        <nav aria-label="Page navigation example">
          <ul class="flex list-style-none">
            <li class="page-item disabled ">
              {{ $expenses->links() }}
            </li>
          </ul>
        </nav>
      </div>
</div>
