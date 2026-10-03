<div class="mb-3">
    <label for="last_closing_amount" class="label_class">Monto de cierre anterior</label>
    <input wire:model.lazy="last_closing_amount" type="number" name="last_closing_amount" class="inputs-formularios-cortos form-control" step="0.01" disabled>
    @error('last_closing_amount')
        <p class=" text-red-600 p-2 rounded">{{ $message }}</p>
    @enderror
</div>

<div class="mb-3">
    <label for="closing_amount" class="label_class">Monto de cierre actual</label>
    <input wire:model.lazy="closing_amount" type="number" name="closing_amount" class="inputs-formularios-cortos form-control" step="0.01" disabled>
    @error('closing_amount')
        <p class=" text-red-600 p-2 rounded">{{ $message }}</p>
    @enderror
</div>

<div>
     <button type="button" class="boton-verde" wire:click="storecalculate()"><i class="fa-solid fa-rotate-right"></i> Recalcular Arqueo</button>
</div>