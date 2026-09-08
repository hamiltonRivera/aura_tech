<div class="mt-6">
    {{-- Buscador sensible --}}
    <div class="mb-3">
        <label for="">Buscador sensible --Productos--</label>
        <input type="text" wire:model.live.debounce.300ms="search_items" placeholder="Busca por código o descripción."
            class="inputs-formularios-cortos">
    </div>

    {{-- Dropdown de Productos --}}
    <div class="mb-3">
        <label for="product_id">Producto</label>
        <select wire:change="buscarProducto($event.target.value)" id="product_id" class="inputs-formularios-cortos"
            wire:model="product_id">
            <option value="">Seleccione un producto</option>
            @foreach ($products as $item)
                <option value="{{ $item->id }}">
                    {{ $item->descripcion }}
                </option>
            @endforeach
        </select>
        @error('product_id')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    {{-- Botón para agregar --}}
    <div class="flex">
        <div class="mr-2">
            <button type="button" wire:click="addItem" class="boton-lima">
                <i class="fa-solid fa-cart-plus"></i> Añadir al combo
            </button>
        </div>
        <div>
            <button type="button" wire:click="clearFields" class="boton-gris">
                <i class="fa-solid fa-eraser"></i> Limpiar campos
            </button>
        </div>
    </div>
    @if (session()->has('error_stock'))
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-2 mb-3 text-xs rounded shadow flex justify-between items-center"
            role="alert">
            <span>{{ session('error_stock') }}</span>
        </div>
    @endif
</div>
