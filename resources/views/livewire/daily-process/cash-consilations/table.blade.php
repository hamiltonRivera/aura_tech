<div class="relative overflow-x-auto">
    <table class="table">
        <thead class="table-thead">
            <tr>
                <th scope="col" class="px-6 py-3">#</th>
                <th scope="col" class="px-6 py-3">Fecha</th>
                <th scope="col" class="px-6 py-3">Cierre Anterior</th>
                <th scope="col" class="px-6 py-3">Apertura del día</th>
                <th scope="col" class="px-6 py-3">Cierre del día</th>
                <th scope="col" class="px-6 py-3">Usuario</th>
             
            </tr>
        </thead>
        <tbody>
           
         @forelse ($arqueos as $arqueo)
        <tr class="bg-white border-b hover:bg-gray-50 text-left text-sm">
            <td class="px-6 py-4">{{ $arqueo->id }}</td>
            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($arqueo->date)->format('d/m/Y') }}</td>
            <td class="px-6 py-4">C$ {{ number_format($arqueo->last_closing_amount, 2) }}</td>
            <td class="px-6 py-4">C$ {{ number_format($arqueo->opening_amount, 2) }}</td>
            <td class="px-6 py-4 text-blue-600 font-bold">C$ {{ number_format($arqueo->closing_amount, 2) }}</td>
            <td class="px-6 py-4">{{ $arqueo->user->name ?? 'Admin' }}</td>
           
        </tr>
    @empty
        <tr>
            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No hay arqueos registrados en el sistema.</td>
        </tr>
    @endforelse
        </tbody>
    </table>
    <div class=" flex justify-left">
        <nav aria-label="Page navigation example">
          <ul class="flex list-style-none">
            <li class="page-item disabled ">
               {{ $arqueos->links() }} 
            </li>
          </ul>
        </nav>
      </div>
</div>
