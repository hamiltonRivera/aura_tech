<div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm">
    <table class="min-w-full bg-white">
        <thead class="bg-blue-600 text-white font-bold">
            <tr>
                <th scope="col" class="px-6 py-3.5 text-center w-16">#</th>
                <th scope="col" class="px-6 py-3.5 text-left"><i class="fa-solid fa-user mr-1"></i> Nombre</th>
                <th scope="col" class="px-6 py-3.5 text-left"><i class="fa-solid fa-envelope mr-1"></i> Correo</th>
                <th scope="col" class="px-6 py-3.5 text-center"><i class="fa-solid fa-check-double mr-1"></i> Rol Actual</th>
                <th scope="col" class="px-6 py-3.5 text-center"><i class="fa-solid fa-list mr-1"></i> Roles</th>
                <th scope="col" class="px-6 py-3.5 text-center"><i class="fa-solid fa-pencil mr-1"></i> Opciones</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-200">
            @foreach ($users as $user)
            <tr class="hover:bg-gray-50 transition-colors">
                <!-- # Número Centrado -->
                <td class="px-6 py-4 text-center text-gray-900 font-bold whitespace-nowrap">
                    {{ $loop->iteration }}
                </td>

                <!-- Nombre -->
                <td class="px-6 py-4 text-left text-gray-900 font-bold whitespace-nowrap">
                    {{ $user->name }}
                </td>

                <!-- Correo -->
                <td class="px-6 py-4 text-left text-gray-900 font-bold whitespace-nowrap">
                    {{ $user->email }}
                </td>

                <!-- Rol Actual -->
                <td class="px-6 py-4 text-center whitespace-nowrap">
                    @if($user->roles->isNotEmpty())
                        <div class="inline-flex items-center justify-center">
                            <i class="fas fa-check text-green-600 mr-1.5 text-lg"></i>
                            <span class="text-gray-900 font-bold">{{ $user->roles->first()->name }}</span>
                        </div>
                    @else
                        <div class="inline-flex items-center justify-center">
                            <i class="fas fa-times text-red-600 mr-1.5 text-lg"></i>
                            <span class="text-red-600 font-bold">Sin Rol</span>
                        </div>
                    @endif
                </td>

                <!-- Selector de Roles -->
                <td class="px-6 py-4 text-center whitespace-nowrap">
                    <select class="p-2 border border-gray-300 rounded-lg text-gray-900 font-bold bg-white focus:ring-blue-500 focus:border-blue-500" wire:model="selectedRole.{{ $user->id }}">
                        <option value="" selected class="font-normal text-gray-500">Seleccione un rol</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" class="text-gray-900 font-bold">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </td>

                <!-- Botón Acción -->
                <td class="px-6 py-4 text-center whitespace-nowrap">
                    <button class="boton-azul font-bold" wire:click="assignRoles">
                        <i class="fa-solid fa-pen-to-square"></i> Asignar Rol
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>