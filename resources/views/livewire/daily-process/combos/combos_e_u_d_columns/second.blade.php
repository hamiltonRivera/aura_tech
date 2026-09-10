<div class="mt-6">
    {{-- Buscador sensible --}}
    <div class="mb-3">
        <label for="" class="label_class">Buscador sensible --Productos--</label>
        <input type="text" wire:model.live.debounce.300ms="search_items" placeholder="Busca por código o descripción."
            class="inputs-formularios-cortos">
    </div>

    {{-- Dropdown de Productos --}}
    <div class="mb-3">
        <label for="product_id" class="label_class">Producto</label>
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

    {{-- Badge de Información de Stock --}}
    @if ($productoSel)
        <div class="flex mb-3 w-100 max-w-sm overflow-hidden bg-black rounded-lg shadow-md dark:bg-gray-800">
            <div class="flex items-center justify-center w-10 bg-blue-500">
                <svg class="w-5 h-5 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z" />
                </svg>
            </div>

            <div class="py-1 px-3">
                <span class="font-semibold text-xs text-blue-500 dark:text-blue-400">Info</span>
                <p class="text-xs text-white">
                    Producto en stock: <span class="font-bold text-blue-300">{{ $productoSel->stock }}</span>
                </p>
            </div>
        </div>
    @endif

    {{-- Botón para agregar --}}
    <div class="flex mb-3">
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

    {{-- Alerta de error en stock --}}
    @if (session()->has('error_stock'))
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-2 mb-3 text-xs rounded shadow flex justify-between items-center"
            role="alert">
            <span>{{ session('error_stock') }}</span>
        </div>
    @endif
</div>
