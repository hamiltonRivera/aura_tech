
    {{-- primer fila --}}
    <div class="mb-3">
        <label for="">Búscador sensible --Productos--</label>
        <input type="search" wire:input="buscarProducto()" wire:model.live="search_product"
            class="inputs-formularios-cortos" placeholder="Búsqueda de productos" autofocus="autofocus" id="">
    </div>

    {{-- segunda fila --}}
    <div class="mb-3">
        <label for="">Cantidad</label>
        <input type="number" name="quantity" wire:model="quantity" wire:change="calcular" min="1"
            max="{{ $productSel ? $productSel->stock : '' }}" class="inputs-formularios-cortos" required>
        @error('quantity')
            <p class="error">{{ $message }}</p>
        @enderror

        @if ($productSel)
            <div class="flex mt-2 w-full max-w-sm overflow-hidden bg-black rounded-lg shadow-md dark:bg-gray-800">
                <div class="flex items-center justify-center w-12 bg-blue-500">
                    <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z" />
                    </svg>
                </div>

                <div class="">
                    <div class="mx-3">
                        <span class="font-semibold text-blue-500 dark:text-blue-400">Info</span>
                        <p class="text-sm text-white">
                            Producto en stock: {{ $productSel->stock }}
                        </p>
                    </div>
                </div>
            </div>
        @endif
        @if (session()->has('cantidad'))
            <div class="bg-red-100 rounded-lg py-5 px-6 mb-3 text-base text-red-700 inline-flex items-center w-full"
                style="width: 80%">

                {{ session('cantidad') }}

            </div>
        @endif
    </div>

    {{-- tercer fila --}}
    <div class="mb-3">
        <button wire:click="clearFields()" class="boton-gris"><i class="fa-solid fa-eraser"></i> Limpiar
            búsqueda</button>
        @if (session()->has('addItem'))
            <div class="bg-red-100 rounded-lg py-5 px-6 mb-3 text-base text-red-700 inline-flex items-center w-full mt-2"
                style="width: 80%">

                {{ session('addItem') }}

            </div>
        @endif

    </div>

    {{-- cuarta fila --}}
     <div class="mb-3">
        @include('newClient')
    </div>

