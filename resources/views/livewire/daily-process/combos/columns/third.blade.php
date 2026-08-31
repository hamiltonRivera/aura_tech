<div class="ml-5 mb-3 mt-3">
    <label for="">Precio del combo</label>
    <input type="number" wire:input.live="total_price" name="total_price" wire:model="total_price" placeholder="Precio:"
        class="inputs-formularios-cortos form-control" required>
    @error('total_price')
        <p class="error">{{ $message }}</p>
    @enderror
</div>

<div class="ml-5 mb-3 mt-3">
    <label for="">-- Stock del combo --</label>
    <input type="number" wire:input.live="stock" name="stock" wire:model="stock" placeholder="Stock:"
        class="inputs-formularios-cortos form-control" required>
    @error('stock')
        <p class="error">{{ $message }}</p>
    @enderror
</div>



<div class="ml-5 mb-3 mt-3">
    <button wire:click="addItem([{{ $product_id }}])" class="boton-lima">
        <i class="fa-solid fa-cart-plus"></i> Añadir a cesta
    </button>
</div>

