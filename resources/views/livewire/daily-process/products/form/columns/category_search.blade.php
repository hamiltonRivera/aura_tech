<div class=" mb-3">
    @if ($selected_id)
    @else
        <label for="" class="label_class">Busqueda sensible de categorías</label>
        <input type="search" wire:model.live="search_category" placeholder="Busqueda de categoría"
            class=" inputs-formularios-cortos form-control">
    @endif
</div>
