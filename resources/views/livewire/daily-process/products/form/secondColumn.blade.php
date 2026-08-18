{{-- prier fila --}}
<div>
    @include('livewire.daily-process.products.form.columns.experation_date')
  </div>

  {{-- segunda fila --}}
  <div>
    @include('livewire.daily-process.products.form.columns.purchases_price')
  </div>

  {{-- tercer fila --}}
  <div>
    @include('livewire.daily-process.products.form.columns.unid_purchases_price')
  </div>

  {{-- cuarto fila --}}
  <div>
    @include('livewire.daily-process.products.form.columns.category_modal')
  </div>

  {{-- quinta fila --}}
  <div class="mt-1">
    <button type="button" class="boton-azul" wire:click="match_prices()"><i class="fa-solid fa-equals"></i> Igualar precios venta</button>
  </div>
