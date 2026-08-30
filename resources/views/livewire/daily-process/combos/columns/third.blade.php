<div class="ml-5 mb-3 mt-3">
    <label for="">Precio del combo</label>
    <input type="number" wire:input.live="total_price" name="total_price" wire:model="total_price" placeholder="Precio:"
        class="inputs-formularios-cortos form-control" required>
    @error('total_price')
        <p class="error">{{ $message }}</p>
    @enderror
</div>

<div class="ml-5 mb-3 mt-3">
    <label for="">Precio con descuento</label>
    <input type="number" wire:input.live="total_discount" name="total_discount" wire:model="total_discount" placeholder="Precio con descuento:"
        class="inputs-formularios-cortos form-control" disabled>
    @error('total_discount')
        <p class="error">{{ $message }}</p>
    @enderror
</div>

