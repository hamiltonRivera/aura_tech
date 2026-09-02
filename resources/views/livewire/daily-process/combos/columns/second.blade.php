<div class="ml-5 mb-3 mt-3">
    <label for="">Buscador sensible --Productos--</label>
    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Busca por código o descripción..."
        class="inputs-formularios-cortos">
</div>

<div class="ml-5 mb-3 mt-3">
    <label for="">Producto Seleccionado</label>
    <input type="text" placeholder="{{ optional($this->productSel)->descripcion }}" disabled
        class="inputs-formularios-cortos" required>

    @if ($productSel)
    <div class="flex mt-2 w-100 max-w-sm overflow-hidden bg-black rounded-lg shadow-md dark:bg-gray-800">
        <div class="flex items-center justify-center w-12 bg-blue-500">
            <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z" />
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
    @if (session()->has('producto'))
        <div class="bg-red-100 rounded-lg py-5 px-6 mb-3 text-base text-red-700 inline-flex items-center w-full"
            style="width: 80%">

            {{ session('producto') }}
        </div>
    @endif
</div>

