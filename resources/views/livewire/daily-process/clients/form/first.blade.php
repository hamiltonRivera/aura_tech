{{-- primer fila --}}
<div>
    <div class="mb-3">
        <label for="" class="label_class">Nombre y Apellido</label>
        <input type="text" name="nombreApellido" wire:model="nombreApellido" placeholder="nombre y apellido:"
            class="inputs-formularios-cortos form-control" required>
    </div>
    @error('nombreApellido')
        <p class=" text-red-600 p-2 rounded">{{ $message }}</p>
    @enderror
</div>

{{-- segunda fila --}}
<div>
    <div class="mb-3">
        <label for="" class="label_class">Ciudad</label>
        <input type="text" name="ciudad" wire:model="ciudad" placeholder="Ciudad:"
            class="inputs-formularios-cortos form-control" required>
    </div>
    @error('ciudad')
        <p class=" text-red-600 p-2 rounded">{{ $message }}</p>
    @enderror
</div>

{{-- tercer fila --}}
<div>
    <label for="" class="label_class">Dirección</label>
    <div class="mb-3">

            <textarea
                class="flex-1 appearance-none border border-gray-300 w-52 py-2 px-4 bg-white text-gray-700 placeholder-gray-400 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                id="comment" placeholder="Dirección:" name="comment" rows="5" cols="10" name="direccion" wire:model="direccion">

    </textarea>


    </div>
    @error('direccion')
        <p class=" text-red-600 p-2 rounded">{{ $message }}</p>
    @enderror
</div>
