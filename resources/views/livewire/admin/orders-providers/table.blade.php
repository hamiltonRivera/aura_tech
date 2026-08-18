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
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $key + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-left">{{ $item['descripcion'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">C$ {{ number_format($item['precio_compra'], 2) }}</td>
                                
                                {{-- Columna de Cantidad con botones - y + --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button type="button" wire:click="decrementarCantidad({{ $key }})" class="px-2 py-1 bg-red-500 text-white rounded text-xs hover:bg-red-600">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>
                                        <span class="font-bold px-2">{{ $item['cantidad'] }}</span>
                                        <button type="button" wire:click="incrementarCantidad({{ $key }})" class="px-2 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">C$ {{ number_format($item['total'], 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <button class="boton-amarillo" wire:click="destroy({{ $key }})" wire:confirm="¿Seguro que deseas eliminar el registro?">
                                        <i class="fa-solid fa-trash"></i>
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