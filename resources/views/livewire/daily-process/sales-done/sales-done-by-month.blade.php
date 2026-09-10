<div>
    <div>
        <label for="" class="ml-3 mb-3" class="label_class">Año 2026</label>
        @include('livewire.daily-process.sales-done.buttons')
    </div>

    <div class="">
        <button type="button" wire:click="show_total()" class="boton-ingresos-egresos">
            Total
        </button>
        <button type="button" wire:click="clear()" class="boton-ingresos-egresos">
            Limpiar Búsqueda
        </button>
    </div>



    <div class="ml-3 mb-5">
        @include('livewire.daily-process.sales-done.show-totals')
    </div>
</div>
