<div class="lg:grid grid-cols-2 sm:grid-col-1">
    {{-- primer columna--}}
  <div>
    <img src="{{ asset('images/balance.jpg') }}" class="img-fluid" alt="">
  </div>

  {{-- segunda columna --}}
  <div>

     <div>
        <div class="inline-flex rounded-md shadow-sm" role="group">
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
          </div>
     </div>
     {{-- mostrar ventas totales de productos --}}
     <div>
        @if ($mostrarVentaProductos)
        @include('livewire.admin.incomes-expenses.vista')
      @endif
     </div>



     {{-- mostrar ventas totales productos + servicios --}}
      <div>
          @if ($mostrarVentaTotales)
            @include('livewire.admin.incomes-expenses.vistaTotal')
          @endif
      </div>

      {{-- mostrar gastos --}}
      <div>
        @if ($mostrarGastos)
         @include('livewire.admin.incomes-expenses.egresos')
        @endif
      </div>
        {{-- mostrar busqueda personalizada --}}
      <div>
        @if ($mostrarBusquedaPersonalizada)
        @include('livewire.admin.incomes-expenses.customResearching')
        @endif
      </div>
      <div>
        @if ($payments)
         @include('livewire.admin.incomes-expenses.abonosCredito')
        @endif
      </div>

  </div>

</div>
