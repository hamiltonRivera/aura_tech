<div>
    <label for="" class="label_class">Árticulos del combo</label>

    <div class="mb-3">
        <label for="" class="label_class">Cantidad</label>
        <input type="number" name="cantidad" wire:model="quantity" min="1" max="" class="inputs-formularios-cortos" required>
        @error('quantity')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    <div>
        @include('livewire.daily-process.combos.table_items')
    </div>
</div>
