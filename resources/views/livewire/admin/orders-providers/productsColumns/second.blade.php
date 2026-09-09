<div>
   {{-- Precio de compra --}}
    <div class="mb-3">
        <label class="label_class">Precio de compra</label>
        <input type="number" step="any" name="precio" wire:model="precio" class="inputs-formularios-cortos bg-gray-100" required disabled>
        @error('precio')
            <p class="text-red-600 font-bold text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Botón de Añadir a cesta --}}
    <div class="mb-3">
        <button type="button" wire:click="addItem([{{ $product_id }}])" class="boton-verde font-bold">
            <i class="fa-solid fa-cart-plus mr-1"></i> Añadir a cesta
        </button>

        @if (session()->has('productoSel'))
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-3 mt-2 rounded font-bold text-sm">
                {{ session('productoSel') }}
            </div>
        @endif
    </div>

    {{-- Botón de Ver órdenes --}}
    <div class="mb-3">
        <a href="{{ route('ordersDone') }}" class="boton-gris font-bold inline-block">
            <i class="fa-solid fa-eye mr-1"></i> Ver órdenes realizadas
        </a>
    </div>

    {{-- Calculadora incluida --}}
    <div>
        @include('calculadora')
    </div>
    
</div>