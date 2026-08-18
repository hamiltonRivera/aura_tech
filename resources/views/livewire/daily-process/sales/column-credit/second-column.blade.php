
    {{-- primer fila --}}
    <div class="mb-3">
        <label for="">Fecha</label><input wire:model.lazy="date" type="date" name="date" class="form-control calendario ms-2" min="2021-01-01" max="2030-12-31" required>
        @error('date')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    {{-- segunda fila --}}
    <div class="mb-3">
        <label for="">fecha limite</label>
        <input wire:model.lazy="due_date" type="date" name="due_date" class="form-control calendario"
            min="2021-01-01" max="2030-12-31" required>
        @if (session()->has('dateError'))
        <div class="bg-red-100 rounded-lg py-5 px-6 mb-3 text-base text-red-700 inline-flex items-center w-full"
            style="width: 80%">

            {{ session('dateError') }}

        </div>
    @endif
        @error('due_date')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>


    {{-- tercer fila  --}}
    <div class="mb-3">
        <label for="">Cliente</label>
        <select name="client_id" wire:model="client_id" class="select-formularios form-select"
            aria-label="Default select example">
            <option selected>Selecciona una opción</option>
            @foreach ($clients as $client)
                <option value="{{ $client->id }}">{{ $client->nombreApellido }}</option>
            @endforeach
        </select>
         @error('client_id')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    {{-- cuarta fila --}}
    <div class="mb-3">
        <div>
            <label for="">Tasa del día</label>
            <input type="text" class="inputs-formularios-cortos" disabled wire:model="exchangeRate"
                value="{{ $exchangeRate }}">
        </div>
    </div>
    {{-- quinta fila --}}
    <div class="mb-3">
        <label for="interest_id">Interés para venta a crédito</label>
        <select name="interest_id" id="interest_id" class="inputs-formularios-cortos" wire:model.live="interest_id">
            <option value="">Seleccione un interés</option>
            @foreach ($interests as $interest)
                <option value="{{ $interest }}">{{ $interest }}</option>
            @endforeach
        </select>
        @error('interest_id')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

