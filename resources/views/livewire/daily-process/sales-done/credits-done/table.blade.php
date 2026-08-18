<div class="relative overflow-x-auto">
    <table class="table">
        <thead class="table-thead">
            <tr>
                <th scope="col" class="px-6 py-3">#</th>
                <th scope="col" class="px-6 py-3"># Factura</th>
                <th scope="col" class="px-6 py-3">Fecha</th>
                <th scope="col" class="px-6 py-3">Fecha fin</th>
                <th scope="col" class="px-6 py-3">Plazo en días</th>
                <th scope="col" class="px-6 py-3">Cliente</th>
                <th scope="col" class="px-6 py-3">Total deuda</th>
                <th scope="col" class="px-6 py-3">Saldo</th>
                <th scope="col" class="px-6 py-3">Estado</th>
                <th scope="col" class="px-6 py-3">Realizado Por</th>
                <th scope="col" class="px-6 py-3">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
              <tr class="tr">
                <td class="td">{{ $loop->iteration }}) </td>
                <td class="td">{{ $sale->voucher_number }} </td>
                <td class="td">{{ $sale->date }} </td>
                <td class="td">{{ $sale->due_date }} </td>
                <td class="td">{{ $sale->days_overdue }} </td>
                <td class="td">{{ $sale->client->nombreApellido }}</td>
                <td class="td">{{ $sale->total_debt }}</td>
                <td class="td">{{ $sale->outstanding_balance }}</td>
                <td class="td">{{ $sale->status }}</td>
                <td class="td">{{ $sale->user->name }}</td>
                <td class="td">
                    <a href="{{ route('detailItems_credit', $sale->id) }}" class="boton-azul" target="_blank"><i class="fa-solid fa-eye"></i> Ver Detalles</a><br><br>
                    <a href="{{ route('payments', $sale->id) }}" class="boton-azul" target="_blank"><i class="fa-solid fa-eye"></i> Ver Pagos</a><br><br>
                    <a href="{{ route('reprint_credit', $sale->id) }}" class="boton-lima"><i class="fa-solid fa-print"></i> Reimprimir</a><br><br>
                    @php
                        $isCancelledCredit = strtolower((string) $sale->status) === 'cancelado' || (float) $sale->outstanding_balance <= 0;
                    @endphp
                    @if ($isCancelledCredit)
                        <button type="button" class="boton-gris opacity-70 cursor-not-allowed" disabled><i class="fa-solid fa-ban"></i> Crédito cancelado</button>
                    @else
                        <button type="button" wire:click="openPaymentModal({{ $sale->id }})" class="boton-verde"><i class="fa-solid fa-money-bill-wave"></i> Aplicar abono</button>
                    @endif
                </td>
              </tr>
            @endforeach

        </tbody>
    </table>
    <div class=" flex justify-left">
        <nav aria-label="Page navigation example">
          <ul class="flex list-style-none">
            <li class="page-item disabled ">
              {{ $sales->links() }}
            </li>
          </ul>
        </nav>
      </div>
</div>
