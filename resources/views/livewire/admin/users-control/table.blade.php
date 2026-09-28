<div>
    <!-- Contenedor principal con scroll en móvil -->
    <div class="w-full overflow-x-auto bg-white shadow-sm rounded-lg mb-4">
        <table class="min-w-full border-collapse text-left text-sm font-light">
            <thead class="bg-blue-600 text-white font-medium">
                <tr>
                    <th scope="col" class="px-6 py-4 text-center">#</th>
                    <th scope="col" class="px-6 py-4 text-center"><i class="fa-solid fa-user"></i> Nombre</th>
                    <th scope="col" class="px-6 py-4 text-center"><i class="fa-solid fa-envelope"></i> Correo</th>
                    <th scope="col" class="px-6 py-4 text-center"><i class="fa-solid fa-check-double"></i> Rol Actual</th>
                    <th scope="col" class="px-6 py-4 text-center"><i class="fa-solid fa-list"></i> Roles</th>
                    <th scope="col" class="px-6 py-4 text-center"><i class="fa-solid fa-gears"></i> Opciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $user)
                    <!-- MUY IMPORTANTE: El wire:key para que Livewire no pierda el rastro del botón -->
                    <tr wire:key="user-{{ $user->id }}" class="border-b transition duration-300 ease-in-out hover:bg-gray-100 text-gray-900 font-medium">
                        <td class="whitespace-nowrap px-6 py-4 text-center text-black">{{ $loop->iteration }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-center text-black">{{ $user->name }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-center text-black">{{ $user->email }}</td>
                        
                        <td class="whitespace-nowrap px-6 py-4 text-center">
                            @if ($user->roles->isNotEmpty())
                                <div class="flex items-center justify-center text-black">
                                    <i class="fas fa-check text-green-500 mr-2"></i>
                                    {{ $user->roles->first()->name }}
                                </div>
                            @else
                                <div class="flex items-center justify-center text-black">
                                    <i class="fas fa-times text-red-500 mr-2"></i>
                                    Sin Rol
                                </div>
                            @endif
                        </td>

                        <td class="whitespace-nowrap px-6 py-4 text-center">
                            <div class="flex justify-center">
                                <select class="p-2 border rounded border-gray-300 text-black bg-white w-full max-w-xs focus:ring-blue-500 focus:border-blue-500"
                                    wire:model="selectedRole.{{ $user->id }}">
                                    <option value="" selected>Seleccione un rol</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>

                        <!-- Botones Compactos -->
                        <td class="whitespace-nowrap px-6 py-4 text-center">
                            <div class="flex justify-center gap-2">
                                <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-3 rounded shadow-sm transition-colors"
                                    wire:click="assignRoles" title="Guardar Rol">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>

                                <!-- Lógica de permisos para el botón de Adelanto -->
                                @php
                                    $nombreRol = $user->roles->first() ? strtolower($user->roles->first()->name) : '';
                                    $puedeAdelanto = in_array($nombreRol, ['caja', 'administrador']);
                                @endphp

                                @if ($puedeAdelanto)
                                    <button class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-3 rounded shadow-sm transition-colors"
                                        wire:click="openAdvanceModal({{ $user->id }})" title="Adelanto de Salario">
                                        <i class="fa-solid fa-money-bill-wave"></i>
                                    </button>
                                @else
                                    <button class="bg-gray-200 text-gray-400 font-bold py-2 px-3 rounded cursor-not-allowed"
                                        disabled title="Opción solo disponible para roles de Caja y Administrador">
                                        <i class="fa-solid fa-money-bill-wave"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="flex justify-left mt-4">
        <nav aria-label="Page navigation example">
            <ul class="flex list-style-none">
                <li class="page-item disabled">
                    {{ $users->links() }}
                </li>
            </ul>
        </nav>
    </div>

    <!-- MODAL DE ADELANTO DE SALARIO -->
    @if ($isAdvanceModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto outline-none focus:outline-none bg-black bg-opacity-50 transition-opacity">
            <div class="relative w-full max-w-md mx-auto my-6">
                <div class="relative flex flex-col w-full bg-white border-0 rounded-lg shadow-lg outline-none focus:outline-none">
                    
                    <!-- Encabezado Modal -->
                    <div class="flex items-start justify-between p-5 border-b border-solid rounded-t border-blueGray-200 bg-blue-600 text-white">
                        <h3 class="text-xl font-semibold">
                            <i class="fa-solid fa-hand-holding-dollar mr-2"></i> Adelanto de Salario
                        </h3>
                        <button class="p-1 ml-auto bg-transparent border-0 text-white float-right text-3xl leading-none font-semibold outline-none focus:outline-none" wire:click="closeAdvanceModal">
                            <span class="bg-transparent text-white h-6 w-6 text-2xl block outline-none focus:outline-none">×</span>
                        </button>
                    </div>

                    <!-- Cuerpo Modal -->
                    <div class="relative p-6 flex-auto">
                        <p class="mb-4 text-gray-600 font-bold">Empleado: <span class="text-blue-600">{{ $advance_user_name }}</span></p>
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Monto a Entregar</label>
                            <input type="number" step="any" wire:model="advance_amount" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('advance_amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Fecha</label>
                            <input type="date" wire:model="advance_date" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('advance_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-3 mt-4 text-sm rounded">
                            <p><i class="fa-solid fa-triangle-exclamation mr-1"></i> Al guardar, este monto se registrará como un <strong>gasto automático</strong> en la caja chica para que cuadre el efectivo entregado hoy.</p>
                        </div>
                    </div>

                    <!-- Footer Modal -->
                    <div class="flex items-center justify-end p-6 border-t border-solid rounded-b border-blueGray-200">
                        <button class="text-gray-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" wire:click="closeAdvanceModal">
                            Cancelar
                        </button>
                        <button class="bg-green-500 text-white active:bg-green-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" wire:click="saveAdvance">
                            <i class="fa-solid fa-check mr-1"></i> Registrar Adelanto
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>