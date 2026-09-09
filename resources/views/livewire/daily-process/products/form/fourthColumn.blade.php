{{-- primer fila --}}
<div>
    @if ($selected_id)
    <button type="button" class="boton-verde" wire:click="update()"><i class="fa-solid fa-pen"></i> Actualizar F2</button>
    @else
    <button type="button" class="boton-azul" wire:click="store()"><i class="fa-solid fa-check"></i> Registrar F1</button>
    @endif
    <button type="button" class="boton-rosa" wire:click="refresh()"><i class="fa-solid fa-arrows-rotate"></i> Refrescar</button>
</div>

{{-- segunda fila--}}


{{-- tercer fila --}}
<div class="mb-3 mt-3">
 @include('calculadora')
</div>





<div class="mb-3">
    <label for="" class="label_class">Productos sin stock</label>
    <input type="number" step="any"
        placeholder="{{ $products_no_stock }}" class="inputs-formularios-cortos form-control" disabled>
</div>

<div class="mb-3">
    <label for="" class="label_class">Total de productos</label>
    <input type="number" step="any"
        placeholder="{{ $total_stock }}" class="inputs-formularios-cortos form-control" disabled>
</div>




{{-- cuarta fila --}}
<div class="mt-3 mb-3">
    <label for="" class="label_class"> C$ Monto total de inventario</label>
    <input type="text"
        value="{{ $total_amount_inventary }}"
        class="inputs-formularios-cortos form-control"
        disabled>
</div>

