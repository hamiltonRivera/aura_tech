<div>
    <div class="ml-5 mb-3 mt-3">
        <label for="" class="label_class">Descripción</label>
        <input type="text" name="description" wire:model="description" placeholder="Descripción:"
            class="inputs-formularios-cortos form-control" required>
    </div>
    @error('description')
        <p class=" text-red-600 p-2 rounded">{{ $message }}</p>
    @enderror


    <div class="ml-5 mb-3 mt-3">
        <label for="" class="label_class">Precio del combo</label>
        <input type="number" wire:input.live="total_price" name="total_price" wire:model="total_price"
            placeholder="Precio:" class="inputs-formularios-cortos form-control" required>
        @error('total_price')
            <p class=" text-red-600 p-2 rounded">{{ $message }}</p>
        @enderror
    </div>



    <div class="ml-5 mb-3 mt-3 flex ">
        <div>
            @if ($comboSel)
                <button type="button" class="boton-verde" wire:click="update()"><i class="fa-solid fa-pen"></i>
                    Actualizar</button>
            @endif
        </div>
        <div class="ml-3">
            <button type="button" class="boton-azul" wire:click="refresh()"><i class="fa-solid fa-arrows-rotate"></i>
                Refrescar</button>
        </div>
    </div>
</div>
