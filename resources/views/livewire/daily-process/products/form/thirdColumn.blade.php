{{-- primer fila --}}
<div>
    @include('livewire.daily-process.products.form.columns.mayor_purchases_price')
  </div>

  {{-- segunda fila --}}
  <div>
      @include('livewire.daily-process.products.form.columns.category_search')
  </div>

  {{-- tercer fila --}}
  <div>
      @include('livewire.daily-process.products.form.columns.category_comboBox')
  </div>

  {{-- cuarta fila --}}
  <div class="mb-3">
    <label for="" class="label_class">Productos en stock</label>
    <input type="number" step="any"
        placeholder="{{ $products_in_stock }}" class="inputs-formularios-cortos form-control" disabled>
</div>

{{-- quinta columna --}}
<div>
    @if ($selected_id)
     <div>
        <label for="" class="label_class">Margen de ganancia</label>
        <input type="number" step="any" disabled class="inputs-formularios-cortos form-control" placeholder="{{ $profit_percent }}">
     </div>
    @endif
</div>
