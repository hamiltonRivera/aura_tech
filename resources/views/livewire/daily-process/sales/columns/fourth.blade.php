{{-- primer fila --}}
<div class="mb-3">
    <label for="" class="label_class">Productos</label>
    <input type="text" wire:model="product_id" placeholder="{{ optional($productSel)->descripcion }}" disabled
        class="inputs-formularios-cortos" required>
    @error('product_id')
        <p class="error">{{ $message }}</p>
    @enderror
    
</div>
{{-- segunda fila --}}
<div class="mb-3">
    <label for="" class="label_class">Precio</label>
    <input type="number" name="precio" wire:model="precio" class="inputs-formularios-cortos" required disabled
        value="{{ optional($productSel)->precio_venta_unidad }}">
    @error('precio')
        <p class="error">{{ $message }}</p>
    @enderror
</div>

{{-- tercer fila --}}
<div class="mb-3">
    <label for="" class="label_class">Descuento individual</label>
    <div>
        <div class="form-check">
            <input value="Si" wire:model="descuento_individual" wire:change="mostarDescuentoIndividual()"
                class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                type="radio" name="flexRadioDefault" id="flexRadioDefault1">
            <label class="form-check-label inline-block text-gray-800" for="flexRadioDefault1">
                Si
            </label>
        </div>
        <div class="form-check">
            <input value="No" wire:model="descuento_individual"
                class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                type="radio" name="flexRadioDefault" id="flexRadioDefault2">
            <label class="form-check-label inline-block text-gray-800" for="flexRadioDefault2">
                No
            </label>
        </div>
    </div>
    @if ($ver_descuento_individual)
        <select name="descuento" wire:model="descuento_i" wire:change="mostarDescuentoIndividual()"
            class="select-formularios form-select" aria-label="Default select example">
            <option selected>Selecciona el descuento</option>
            @foreach ($descuentos as $descuento)
                <option value="{{ $descuento->percent }}">{{ $descuento->percent }}%</option>
            @endforeach
        </select>
    @endif
</div>

{{-- cuarta fila --}}
<div class="mb-3">
    @if ($productSel && $productSel->stock <= 0)
        {{-- ✅ Alerta cuando no hay stock en producto individual --}}
        <div class="flex mt-2 w-full max-w-sm overflow-hidden bg-black rounded-lg shadow-md dark:bg-gray-800 mb-3">
            <div class="flex items-center justify-center w-12 bg-red-500">
                <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z" />
                </svg>
            </div>

            
        </div>
        {{-- Botón deshabilitado --}}
        <button class="boton-lima opacity-50 cursor-not-allowed mt-3" disabled>
            <i class="fa-solid fa-cart-plus"></i> Añadir a cesta
        </button>
    @else
        {{-- Botón activo --}}
        <button wire:click="addItem([{{ $product_id }}])" class="boton-lima">
            <i class="fa-solid fa-cart-plus"></i> Añadir a cesta
        </button>
    @endif

    {{-- ✅ Alerta que atrapa la validación de combos o falta de stock al pulsar el botón --}}
    @if (session()->has('addItem'))
        <div class="flex mt-3 w-full max-w-sm overflow-hidden bg-black rounded-lg shadow-md dark:bg-gray-800">
            <div class="flex items-center justify-center w-12 bg-red-500">
                <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z" />
                </svg>
            </div>

            <div class="px-4 py-2 -mx-3">
                <div class="mx-3">
                    <span class="font-semibold text-red-500 dark:text-red-400">Sin Stock Suficiente</span>
                    <p class="text-sm text-white">
                        {{ session('addItem') }}
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>