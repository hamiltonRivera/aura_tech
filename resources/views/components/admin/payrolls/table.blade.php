<div class="relative overflow-x-auto mr-5">
    <table class="table w-full">
        <thead class="table-thead">
            <tr>
                <th scope="col" class="px-6 py-3">#</th>
                <th scope="col" class="px-6 py-3">Empleado</th>
                <th scope="col" class="px-6 py-3">Período</th>
                <th scope="col" class="px-6 py-3">Salario Mensual</th>
                <th scope="col" class="px-6 py-3">Bruto Quincenal</th>
                <th scope="col" class="px-6 py-3">INSS</th>
                <th scope="col" class="px-6 py-3">IR</th>
                <th scope="col" class="px-6 py-3">Neto a Pagar</th>
                <th scope="col" class="px-6 py-3">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payrolls as $payroll)
              <tr class="tr text-center">
                <td class="td">{{ $loop->iteration }}</td>
                
                {{-- Relación con el modelo User --}}
                <td class="td font-semibold">{{ $payroll->user->name ?? 'Desconocido' }}</td>
                
                {{-- Fechas concatenadas --}}
                <td class="td whitespace-nowrap">{{ $payroll->start_date }} al {{ $payroll->end_date }}</td>
                
                <td class="td">{{ number_format($payroll->monthly_salary, 2) }}</td>
                <td class="td">{{ number_format($payroll->total_payment_quarter, 2) }}</td>
                
                {{-- Deducciones en texto rojo --}}
                <td class="td text-red-500">{{ number_format($payroll->inss_deduction, 2) }}</td>
                <td class="td text-red-500">{{ number_format($payroll->ir_deduction, 2) }}</td>
                
                {{-- Neto en texto verde y negrita --}}
                <td class="td font-bold text-green-600">{{ number_format($payroll->net_payment_quarter, 2) }}</td>
                
                <td class="td flex justify-center space-x-2">
                    <button type="button" class="boton-azul mb-1" wire:click="edit({{ $payroll->id }})">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>

                    <button type="button" class="boton-amarillo mb-1" onclick="confirmarEliminacion({{ $payroll->id }})" wire:confirm="¿Seguro que deseas eliminar este registro de planilla?">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>
              </tr>
            @endforeach

        </tbody>
    </table>
    
    <div class="flex justify-left mt-4">
        <nav aria-label="Page navigation example">
          <ul class="flex list-style-none">
            <li class="page-item disabled">
              {{ $payrolls->links() }}
            </li>
          </ul>
        </nav>
    </div>
</div>