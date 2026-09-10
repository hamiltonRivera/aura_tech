<div class="ml-5 mb-3 mt-3">
    <label for="" class="label_class">Descripción</label>
    <input type="text" name="description" wire:model="description" placeholder="Descripción:"
        class="inputs-formularios-cortos form-control" required>
</div>
@error('description')
    <p class=" text-red-600 p-2 rounded">{{ $message }}</p>
@enderror

<div class="ml-5 mb-3 mt-3">
    <label for="" class="label_class">Cantidad</label>
    <input type="number" name="cantidad" wire:model="quantity" min="1"
        max="{{ $productSel ? $productSel->stock : '' }}" class="inputs-formularios-cortos" required>
    @error('quantity')
        <p class=" text-red-600 p-2 rounded">{{ $message }}</p>
    @enderror

    
</div>

<div class="ml-5 mb-3 mt-3">
    <button type="button" class="boton-rosa" wire:click="store()"><i class="fa-solid fa-check"></i> Registrar
        Combo</button>
</div>


