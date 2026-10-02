{{-- primer fila --}}
<div>
    <div class="mb-3">
        <label for="" class="form-label label_class">Método de cancelación</label>
        <select name="metodoPago" wire:model="metodoPago" class="select-formularios form-select"
            aria-label="Default select example">
            <option selected>Selecciona una opción</option>
            @foreach ($metodoPagos as $j)
                <option value="{{ $j }}">{{ $j }}</option>
            @endforeach
        </select>
    </div>
    @error('metodoPago')
        <p class="text-red-600 p-2 rounded">{{ $message }}</p>
    @enderror
</div>

{{-- NUEVA FILA: ¿Incluye Delivery? --}}
<div>
    <div class="mb-3">
        <label class="form-label label_class">¿Incluye Delivery?</label>
        <div class="flex gap-4 mt-1">
            <label class="flex items-center">
                <input type="radio" wire:model.live="incluyeDelivery" value="no" class="form-radio text-blue-600">
                <span class="ml-2 text-sm text-gray-700">No</span>
            </label>
            <label class="flex items-center">
                <input type="radio" wire:model.live="incluyeDelivery" value="si" class="form-radio text-blue-600">
                <span class="ml-2 text-sm text-gray-700">Sí</span>
            </label>
        </div>
    </div>
</div>

{{-- NUEVA FILA: Monto del Delivery (Aparece solo si elige "Sí") --}}
@if($incluyeDelivery === 'si')
<div>
    <div class="mb-3">
        <label class="form-label label_class">Monto del Delivery</label>
        <input type="number" step="any" class="select-formularios form-select" wire:model.live="montoDelivery" placeholder="Ej: 50">
    </div>
</div>
@endif

{{-- segunda fila (Total a pagar) --}}
<div>
    <div class="mb-3">
        <label for="" class="label_class">Total a pagar</label>
        <input type="number" step="any" class="select-formularios form-select" name="totalPagado"
            wire:model="totalPagado" disabled>
        @error('totalPagado')
            <p class="text-red-600 p-2 rounded">{{ $message }}</p>
        @enderror
    </div>
</div>

{{-- tercer fila (Botones) --}}
<div>
    <div class="mb-2 mt-4">
        <button class="boton-azul" wire:click="store()"><i class="fa-solid fa-pen"></i> registrar</button>
        <button class="boton-rosa mb-3" wire:click="refresh()"><i class="fa-solid fa-arrows-rotate"></i> Refrescar</button>
    </div>
</div>