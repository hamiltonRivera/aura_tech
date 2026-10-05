<br>
<div>
  <div>
      <div class="text-center">
          <label for="" class="label_class"><u>Productos</u></label><hr>
      </div><br>
      <div class="text-center">
        <label for="" class="text-center label_class">Ingresos Totales</label>
      </div>
      <div class="lg:grid grid-cols-2 sm:grid-col-1">
        {{-- primer columna --}}
        <div>
           {{-- primer fila --}}
           <div>
              <div class="ml-5">
                  <label for="" class="label_class">Selecciona una fecha</label>
                  <input wire:model.lazy="fecha" wire:change="cierreDelDia()" type="date" class="form-control calendario" min="2021-01-01" max="2030-12-31">
              </div>
           </div>
        </div>

        {{-- segunda columna --}}
        <div>
          {{-- primer fila --}}
          <div>
              <div class="">
                  <label for="" class="label_class">Cierre del dia</label>
              <input type="number" step="any" class="inputs-formularios-cortos" placeholder="Cierre del día:" wire:model="cierre" disabled>
              </div>
          </div>
        </div>
      </div>


    @include('livewire.admin.incomes-expenses.metodos-pagos.efectivo')
    @include('livewire.admin.incomes-expenses.metodos-pagos.transferencia')
    @include('livewire.admin.incomes-expenses.metodos-pagos.tarjeta')

  </div>

</div>
