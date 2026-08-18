<div>
    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="border-b bg-blue-600 text-white">
                            <tr class="text-center">
                                <th scope="col" class="tr-th">#</th>
                                <th scope="col" class="tr-th">Fecha última cuota</th>
                                <th scope="col" class="tr-th">Método de Pago</th>
                                <th scope="col" class="tr-th">Total Recibido</th>
                                <th scope="col" class="tr-th">Monto Abono</th>
                                <th scope="col" class="tr-th">Cambio</th>
                                <th scope="col" class="tr-th">Observaciones</th>
                            </tr>
                        </thead>
                        <tbody>

                            @php
                                $num = 0;
                            @endphp

                            @foreach ($payments as $item)
                              <tr class="text-center border-b">
                                <td class="tr-td">{{ $loop->iteration }}</td>
                                <td class="tr-td">{{ $item->payment_date }}</td>
                                <td class="tr-td">{{ $item->payment_method }}</td>
                                <td class="tr-td">{{ number_format($item->amount_received, 2    ) }}</td>
                                <td class="tr-td">{{ number_format($item->amount_paid, 2) }}</td>
                                <td class="tr-td">{{ number_format($item->change_given, 2) }}</td>
                                <td class="tr-td">{{ $item->observations }}</td>
                              </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class=" flex justify-left">
        <nav aria-label="Page navigation example">
          <ul class="flex list-style-none">
            <li class="page-item disabled">
              {{ $payments->links() }}
            </li>
          </ul>
        </nav>
      </div>
</div>
