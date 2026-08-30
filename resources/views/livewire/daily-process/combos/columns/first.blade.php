<div class="ml-5 mb-3 mt-3">
    <label for="">Descripción</label>
    <input type="text" name="descripcion" wire:model="descripcion" placeholder="Descripción:"
        class="inputs-formularios-cortos form-control" required>
</div>
@error('descripcion')
    <p class=" text-red-600 p-2 rounded">{{ $message }}</p>
@enderror

<div class="ml-5 mb-3 mt-3">
    <label for="">cantidad</label>
    <input type="number" min="1" max="{{ optional($this->productSel)->stock ?? 9999 }}" wire:model.live="quantity" name="quantity" placeholder="cantidad:"
        class="inputs-formularios-cortos forn-control" required>
    @error('quantity')
        <p class="error">{{ $message }}</p>
    @enderror
</div>

<div class="ml-5 mb-3 mt-3">
    <button type="button" class="boton-rosa" wire:click="store()"><i class="fa-solid fa-check"></i> Registrar
        Combo</button>
</div>


