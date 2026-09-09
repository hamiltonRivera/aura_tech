<div class="mb-3">
    <label for="" class="label_class">Código</label>
    <input type="string" wire:model="codigo" placeholder="Código:" class="inputs-formularios-cortos" autofocus required>
</div>
@error('codigo')
<p class=" text-red-600 p-2 rounded">{{ $message }}</p>
@enderror
