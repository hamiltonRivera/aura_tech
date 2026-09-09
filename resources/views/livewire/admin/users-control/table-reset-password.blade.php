<div>
    <div class="lex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="overflow-x-auto">
          <table class="min-w-full">
            <thead class="order-b bg-blue-600 text-white">
                <th scope="col" class="px-6 py-3">#</th>
               <th scope="col" class="px-6 py-3"><i class="fa-solid fa-user"></i> Nombre</th>
                <th scope="col" class="px-6 py-3"><i class="fa-solid fa-envelope"></i> Correo</th>
                <th scope="col" class="px-6 py-3"><i class="fa-solid fa-pencil"></i> Opciones</th>

            </thead>

            <tbody>
                @foreach ($users as $user)
                <tr class="text-center border-b ml-10">
                    <td class="tr-td px-6 py-4 text-left text-gray-900 font-bold whitespace-nowrap">{{ $loop->iteration }} </td>
                    <td class="tr-td px-6 py-4 text-left text-gray-900 font-bold whitespace-nowrap">{{ $user->name }}</td>
                    <td class="tr-td px-6 py-4 text-left text-gray-900 font-bold whitespace-nowrap">{{ $user->email }}</td>
                    <td class="td">
                    <button type="button" class="boton-azul" wire:click="edit({{ $user->id }})">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                </td>
                </tr>

                @endforeach
            </tbody>
          </table>
        </div>
        </div>
    </div>
    <div class=" flex justify-left">
        <nav aria-label="Page navigation example">
          <ul class="flex list-style-none">
            <li class="page-item disabled ">
              {{ $users->links() }}
            </li>
          </ul>
        </nav>
      </div>
</div>
