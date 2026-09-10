{{-- primer fila  --}}
<div class="mb-3">
    <label for="" class ="label_class">Cliente</label>
    <select name="client_id" wire:model="client_id" class="select-formularios form-select"
        aria-label="Default select example">
        <option selected>Selecciona una opción</option>
        @foreach ($clients as $client)
            <option value="{{ $client->id }}">{{ $client->nombreApellido }}</option>
        @endforeach
    </select>
</div>

{{-- segunda fila --}}
<div class="mb-3">
    <div class="mb-3">
        <label for="" class="label_class">Tasa del día</label>
        <input type="text" class="inputs-formularios-cortos" disabled wire:model="exchangeRate"
            value="{{ $exchangeRate }}">
    </div>
</div>

{{-- octava fila --}}
<div class="mb-3">
    @include('newClient')
</div>

{{-- septima fila --}}
<div class="mb-3">
    @include('calculadora')
</div>
