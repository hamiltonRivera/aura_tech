<div>
    {{-- Búsqueda sensible --}}
    <div class="mb-3">
        <label class="label_class">Búsqueda sensible</label>
        <input wire:model.live="users" type="search" placeholder="Descripción del producto..." class="inputs-formularios-cortos">
    </div>

    {{-- Selector de productos --}}
    <div class="mb-3">
        <label class="label_class">Productos</label>
        <select name="product_id" wire:model="product_id" wire:change="buscarProducto($event.target.value)" class="select-formularios form-select">
            <option value="">Selecciona una opción</option>
            @foreach ($products as $product)
                <option value="{{ $product->id }}">{{ $product->descripcion }}</option>
            @endforeach
        </select>
        @error('product_id')
            <p class="text-red-600 font-bold text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <div class="mb-3">
            <label class="label_class">Cantidad</label>
            <input type="number" step="any" name="cantidad" wire:model="cantidad" class="inputs-formularios-cortos" required min="1">
        </div>
        @error('cantidad')
            <p class="text-red-600 font-bold text-sm mt-1">{{ $message }}</p>
        @enderror

        @if ($productoSel)
            <div class="flex w-full max-w-sm overflow-hidden bg-white rounded-lg shadow-md border border-gray-200 mt-2">
                <div class="flex items-center justify-center w-12 bg-blue-600">
                    <i class="fa-solid fa-circle-info text-white text-lg"></i>
                </div>
                <div class="px-4 py-2">
                    <span class="font-bold text-blue-600 block">Información</span>
                    <p class="text-sm font-bold text-gray-900">Stock actual: {{ $productoSel->stock }}</p>
                </div>
            </div>
        @endif

        @if (session()->has('cantidad'))
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-3 mt-2 rounded font-bold text-sm">
                {{ session('cantidad') }}
            </div>
        @endif
    </div>
</div>