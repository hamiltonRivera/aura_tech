<div class="mb-3">
    <label for="date">Fecha del arqueo</label>
    <input wire:model.lazy="date" type="date" name="date" class="form-control calendario"
        min="2021-01-01" max="2030-12-31">
    @error('date')
        <p class=" text-red-600 p-2 rounded">{{ $message }}</p>
    @enderror
</div>

<div class="mb-3">
    <label for="opening_amount">Monto Apertura</label>
    <input wire:model.lazy="opening_amount" 
       type="number" 
       name="opening_amount" 
       class="inputs-formularios-cortos form-control {{ $is_opening_locked ? 'bg-gray-200 cursor-not-allowed' : '' }}" 
       @if($is_opening_locked) readonly @endif>
    @error('opening_amount')
        <p class=" text-red-600 p-2 rounded">{{ $message }}</p>
    @enderror
</div>

<div>
     <button type="button" class="boton-azul" wire:click="store()"><i class="fa-solid fa-floppy-disk"></i> Registrar Arqueo</button>
</div>
