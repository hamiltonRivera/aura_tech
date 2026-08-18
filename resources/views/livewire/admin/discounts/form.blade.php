<div class="" wire:key="{{ $selected_id ?? 'new' }}">
    <div>
        <h3 class="text-center">Descuentos</h3>
    </div>

    <div class="mt-3 mb-3">
        <div class="mb-3">
            <label for="">%</label>
            <input type="number" step="any" name="percent" wire:model="percent" placeholder="Ingresa el porcentaje:"class="inputs-formularios-cortos"required>
        </div>
        @error('percent')
        <p class=" text-red-600 p-2 rounded">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <div class="mb-3">
            @if ($selected_id)
            <button type="button" class="boton-verde" wire:click="update()"><i class="fa-solid fa-pen"></i> actualizar</button>
            @else
            <button type="button" class="boton-rosa" wire:click="store()"><i class="fa-solid fa-check"></i> Registrar</button>
            @endif
        </div>
    </div>

   <div class="lg:grid grid-cols-2 sm:grid-col-1">
    <div>
        <form wire:submit.prevent="import" enctype="multipart/form-data">
            <div class="mb-3">
                <input name="carga" wire:model="carga" type="file" id="carga" class="input-carga-excel" accept=".xlsx">

                <div wire:loading wire:target="carga" wire:key="carga"><i class="fa-solid fa-atom"></i>Cargando</div>
                <div wire:loading wire:target="import" wire:key="import"><i class="fa-solid fa-atom"></i>Cargando</div>
            </div>

            <div class="flex items-center mt-2 mb-3">
                <button class="boton-carga-excel">
                    <i class="fa-solid fa-file-arrow-up"></i> Cargar Archivo
                </button>

                <button type="button" class="boton-amarillo ml-2" wire:click="deleteAll()" wire:confirm="Seguro que deseas eliminar los registros?">
                    <i class="fa-solid fa-trash"></i> Eliminar Todo
                </button>
            </div>
        </form>
    </div>
</div>





</div>
