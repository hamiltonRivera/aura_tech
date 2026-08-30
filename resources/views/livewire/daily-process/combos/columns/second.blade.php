<div class="ml-5 mb-3 mt-3">
    <label for="">Buscador sensible --Productos--</label>
    <input type="text" wire:model.live.debounce.300ms="search_product" placeholder="Busca por código o descripción..."
        class="inputs-formularios-cortos">
</div>

<div class="ml-5 mb-3 mt-3">
    <label for="">Producto Seleccionado</label>
    <input type="text" placeholder="{{ optional($this->productSel)->descripcion }}" disabled
        class="inputs-formularios-cortos" required>

    @if ($this->productSel)
        <p class="text-green-600 text-sm mt-1">Producto en stock: {{ $this->productSel->stock }}</p>
    @else
        @if (session()->has('producto'))
            <p class="text-red-600 text-sm mt-1">{{ session('producto') }}</p>
        @endif
    @endif
</div>