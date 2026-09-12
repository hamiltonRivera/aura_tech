<div class="flex flex-col">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="border-b bg-blue-600 text-white">
                        <tr>
                            <th scope="col" class="tr-th">#</th>
                            <th scope="col" class="tr-th">Descripción</th>
                            <th scope="col" class="tr-th">Precio</th>
                            <th scope="col" class="tr-th">Cantidad</th>
                            <th scope="col" class="tr-th">Subtotal</th>
                            <th scope="col" class="tr-th">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detailProduct as $key => $item)
                            <tr class="text-center">
                                <td class="font-bold text-gray-900">{{ $key + 1 }}</td>
                                <td class="font-bold text-gray-900">{{ $item['descripcion'] }}</td>
                                <td class="font-bold text-gray-900">{{ $item['precio_venta'] }}</td>
                                <td>
                                    <!-- Controles de Cantidad -->
                                    <div class="flex items-center justify-center space-x-2">
                                        <!-- Botón MENOS: Fondo Rojo, Texto Blanco -->
                                        <button type="button" wire:click="decrementarCantidad({{ $key }})"
                                            class="bg-red-500 hover:bg-red-600 text-white font-bold px-2 py-1 rounded shadow text-xs">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>

                                        <span
                                            class="font-semibold w-8 text-center text-gray-700">{{ $item['cantidad'] }}</span>

                                        <!-- Botón MÁS: Fondo Verde, Texto Blanco -->
                                        <button type="button" wire:click="incrementarCantidad({{ $key }})"
                                            class="bg-green-500 hover:bg-green-600 text-white font-bold px-2 py-1 rounded shadow text-xs">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="font-bold text-gray-900">{{ $item['total'] }}</td>
                                <td>
                                    <button class="boton-eliminar" wire:confirm="Confirmacion de eliminar producto"
                                        wire:click="destroy({{ $key }})">
                                        <i class="fa-solid fa-trash boton-rosa"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
