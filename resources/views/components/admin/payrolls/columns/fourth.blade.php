<div class="ml-5 mb-3 mt-3">
    {{-- primer fila  --}}
    <div class="mb-3">
        <label for="" class="label_class">Total devengado mensual</label>
        <input type="number" step="any" wire:model="total_payment_monthly" name="daily_salary"
            placeholder="Salario diario" class="inputs-formularios-cortos form-control" disabled>

        @error('total_payment_monthly')
            <p class=" text-red-600 p-2 rounded">{{ $message }}</p>
        @enderror
    </div>

    {{-- segunda fila --}}
    <div class="mb-3">
        <label for="" class="label_class">Total devengado quincenal</label>
        <input type="number" step="any" wire:model="total_payment_quarter" name="daily_salary"
            placeholder="Salario diario" class="inputs-formularios-cortos form-control" disabled>

        @error('total_payment_quarter')
            <p class=" text-red-600 p-2 rounded">{{ $message }}</p>
        @enderror
    </div>

    {{-- tercer fila --}}
    <div class="mb-3">
        <label for="" class="label_class text-green-600 font-bold">Neto a recibir (Quincena)</label>
        <input type="number" step="any" wire:model="net_payment_quarter" name="net_payment_quarter"
            placeholder="0.00" class="inputs-formularios-cortos form-control bg-green-100 font-bold" disabled>
    </div>

    {{-- cuarta fila --}}
    <div>
        {{-- IR (Condicional) --}}
        @if ($apply_deductions === 'si')
            <div class="mb-3">
                <label for="" class="label_class text-red-500 font-semibold">Deducción IR</label>
                <input type="number" step="any" wire:model="ir_deduction"
                    class="inputs-formularios-cortos form-control bg-red-50 text-red-700" disabled>
            </div>
        @endif
    </div>

    {{-- quinta fila  --}}
    <div>
        <div class="mb-3">
        @if ($selected_id)
        <button type="button" class="boton-verde" wire:click="update()"><i class="fa-solid fa-pen"></i> Actualizar</button>
        @else
        <button type="button" class="boton-rosa" wire:click="store()"><i class="fa-solid fa-check"></i> Registrar</button>
        @endif
        <button type="button" class="boton-azul" wire:click="refresh()"><i class="fa-solid fa-arrows-rotate"></i> Refrescar</button>
    </div>
    </div>    

</div>