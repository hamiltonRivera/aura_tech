<div>
    <div class="relative overflow-x-auto">
        <table class="table">
            <thead class="table-thead">
                <tr>
                    <th scope="col" class="px-6 py-3">#</th>
                    <th scope="col" class="px-6 py-3">DESCRIPCION</th>
                    <th scope="col" class="px-6 py-3">CANTIDAD</th>
                    <th scope="col" class="px-6 py-3">OPCIONES</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($itemsCombo as $key => $item)
                    <tr class="tr text-center">
                        <td class="td">{{ $key + 1 }})</td>
                        <td class="td">{{ $item['descripcion'] }}</td>
                        <td class="td">
                            <!-- Controles de Cantidad -->
                            <div class="flex items-center justify-center space-x-2">
                                <!-- Botón MENOS -->
                                <button type="button" wire:click="decrementarCantidad({{ $key }})"
                                    class="bg-red-500 hover:bg-red-600 text-white font-bold px-2 py-1 rounded shadow text-xs">
                                    <i class="fa-solid fa-minus"></i>
                                </button>

                                <span class="font-semibold w-8 text-center text-gray-700">
                                    {{ $item['cantidad'] }}
                                </span>

                                <!-- Botón MÁS -->
                                <button type="button" wire:click="incrementarCantidad({{ $key }})"
                                    class="bg-green-500 hover:bg-green-600 text-white font-bold px-2 py-1 rounded shadow text-xs">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </td>
                        <td class="td">
                            <button type="button" class="boton-amarillo" wire:click="removeItem({{ $key }})">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr class="tr">
                        <td colspan="4" class="td text-center py-4">
                            No hay productos agregados al combo.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
