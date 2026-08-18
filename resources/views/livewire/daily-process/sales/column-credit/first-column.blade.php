    {{-- primera fila --}}
    <div class="mb-3">
        <label for="">No de factura</label>
        <input type="number" step="any" name="voucher_number" wire:model="voucher_number"
            class="inputs-formularios-cortos" required disabled>
        @error('voucher_number')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    {{-- segunda fila --}}
    <div class="mb-3">
        <label for="">Búsqueda sensible --cliente--</label>
        <input type="search" wire:model.live="search_client" class="inputs-formularios-cortos"
            placeholder="Búsqueda de cliente">
    </div>

    {{-- tercer fila --}}
    <div class="mb-3">

        <label for="">Total a pagar</label>
        <input type="number" step="any" name="total_debt" wire:model.lazy="total_debt" required
            class=" inputs-formularios-cortos" disabled>
        @error('total_debt')
            <p class="error"> {{ $message }} </p>
        @enderror

    </div>

    {{-- cuarta fila --}}
       <div class="mb-3">
        <label for="days_overdue">Días de acuerdo:</label>
         <input type="number" min="1" name="days_overdue" id="days_overdue" class="inputs-formularios-cortos"
             wire:model="days_overdue" value="{{ $this->getPaymentTermDays() }}" readonly disabled>
        @error('days_overdue')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    {{-- quinta fila --}}

     <div class="mb-3">
        @include('calculadora')
    </div>

    {{-- sexta fila --}}
    <div class="mb-3">
        <button wire:click="store()" class="boton-rosa"><i class="fa-solid fa-check"></i> Realizar venta</button>
    </div>

    {{-- mensaje de error de venta bonito debajo del botón --}}
    @if (session()->has('error'))
        <div class="mb-3 flex items-center justify-center">
            <div class="flex items-center border border-red-400 bg-red-100 text-red-700 px-4 py-3 rounded relative shadow-sm w-full max-w-xs">
                <span class="mr-2">
                    <i class="fa-solid fa-circle-exclamation fa-lg"></i>
                </span>
                <span class="flex-1 text-center font-semibold">
                    {{ session('error') }}
                </span>
            </div>
        </div>
    @endif

