<div>
    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full bg-white">
                        <thead class="border-b bg-blue-600 text-white font-bold">
                            <tr class="text-center">
                                <th scope="col" class="px-6 py-3">#</th>
                                <th scope="col" class="px-6 py-3 text-left">Producto</th>
                                <th scope="col" class="px-6 py-3">Precio</th>
                                <th scope="col" class="px-6 py-3">Cantidad</th>
                                <th scope="col" class="px-6 py-3">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach ($items as $item)
                              <tr class="text-center hover:bg-gray-50" wire:key="item-{{ $item->id }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 text-left">{{ $item->product->descripcion ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">C$ {{ number_format($item->price, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $item->quantity }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">C$ {{ number_format($item->total, 2) }}</td>
                              </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-left mt-4">
        <nav aria-label="Page navigation example">
          <ul class="flex list-style-none">
            <li class="page-item disabled">
              {{ $items->links() }}
            </li>
          </ul>
        </nav>
    </div>
</div>