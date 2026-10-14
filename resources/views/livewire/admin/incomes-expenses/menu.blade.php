<div>
    <div class="lg:grid grid-cols-2 sm:grid-col-1">
        {{-- primer columna --}}
        <div>
            <img src="{{ asset('images/balance.jpg') }}" class="img-fluid" alt="">
        </div>

        {{-- segunda columna --}}
        <div>
            {{-- Barra de Botones Superior --}}
            <div>
                <div class="inline-flex rounded-md shadow-sm flex-wrap gap-1" role="group">
                    <button type="button" wire:click="mostrarVentaProducto()" class="boton-ingresos-egresos">
                        Mostrar Ventas
                    </button>
                    <button type="button" wire:click="mostrarEgresos()" class="boton-ingresos-egresos">
                        Mostrar Gastos
                    </button>
                    <button type="button" wire:click="busquedaPersonalizada()" class="boton-ingresos-egresos">
                        Búsqueda Personalizada
                    </button>
                    <button type="button" wire:click="limpiarEntorno()" class="boton-ingresos-egresos">
                        Limpiar Búsqueda
                    </button>
                    <button type="button" wire:click="show_credits_payments()" class="boton-ingresos-egresos">
                        Abonos a créditos
                    </button>
                    <button type="button" wire:click="show_balance()" class="boton-ingresos-egresos">
                        Mostrar Balance
                    </button>
                </div>
            </div>

            {{-- ÁREA DE VISTAS DINÁMICAS (Todas se cargan aquí abajo) --}}
            <div class="mt-4">
                {{-- mostrar ventas totales de productos --}}
                @if ($mostrarVentaProductos)
                    @include('livewire.admin.incomes-expenses.vista')
                @endif

                {{-- mostrar ventas totales productos + servicios --}}
                @if ($mostrarVentaTotales)
                    @include('livewire.admin.incomes-expenses.vistaTotal')
                @endif

                {{-- mostrar gastos --}}
                @if ($mostrarGastos)
                    @include('livewire.admin.incomes-expenses.egresos')
                @endif

                {{-- mostrar busqueda personalizada --}}
                @if ($mostrarBusquedaPersonalizada)
                    @include('livewire.admin.incomes-expenses.customResearching')
                @endif
                {{-- mostrar balance --}}
                @if ($mostrarBalance)
                    @include('livewire.admin.incomes-expenses.balance')
                @endif
            </div>

        </div>
    </div>
</div>