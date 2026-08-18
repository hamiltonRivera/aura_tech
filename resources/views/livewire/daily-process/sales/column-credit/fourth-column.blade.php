
    {{-- primer fila --}}
<div class="mb-3">
    <label for="">Productos</label>
    <input type="text" wire:model="product_id" placeholder="{{ optional($productSel)->descripcion }}" disabled
        class="inputs-formularios-cortos" required>
    @error('product_id')
        <p class="error">{{ $message }}</p>
    @enderror
    @if (session()->has('producto'))
        <div class="bg-red-100 rounded-lg py-5 px-6 mb-3 text-base text-red-700 inline-flex items-center w-full"
            style="width: 80%">

            {{ session('producto') }}

        </div>
    @endif
</div>
{{-- segunda fila --}}
<div class="mb-3">
    <label for="">Precio
        @if($credit_price && $price && $credit_price != $price)
            <span class="text-xs text-green-600 font-semibold ml-1">
                (+{{ round(($credit_price - $price), 2) }} de interés)
            </span>
        @endif
    </label>
    <input type="number" step="any" wire:model="credit_price" class="inputs-formularios-cortos" disabled
        placeholder="Seleccione un interés">
</div>

{{-- tercer fila --}}
<div class="mb-3">
    @if ($productSel && $productSel->stock <= 0)
        {{-- ✅ Alerta cuando no hay stock --}}
        <div class="flex mt-2 w-full max-w-sm overflow-hidden bg-black rounded-lg shadow-md dark:bg-gray-800">
        <div class="flex items-center justify-center w-12 bg-red-500">
            <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z" />
            </svg>
        </div>

        <div class="px-4 py-2 -mx-3">
            <div class="mx-3">
                <span class="font-semibold text-red-500 dark:text-red-400">Alerta</span>
                <p class="text-sm text-white">
                    No se puede agregar este producto porque no hay stock disponible.
                </p>
            </div>
        </div>
    </div>
        {{-- Botón deshabilitado --}}
        <button class="boton-lima opacity-50 cursor-not-allowed mt-3" disabled>
            <i class="fa-solid fa-cart-plus"></i> Añadir a cesta
        </button>
    @else
        {{-- Botón activo solo si hay stock --}}
        <button wire:click="addItem([{{ $product_id }}])" class="boton-lima">
            <i class="fa-solid fa-cart-plus"></i> Añadir a cesta
        </button>
    @endif
</div>

{{-- cuarta fila --}}
<div>
    <a href="{{ route('credit_sales_done') }}" class="boton-rosa"><i class="fa-solid fa-binoculars"></i> Ver ventas al crédito</a>
</div>

