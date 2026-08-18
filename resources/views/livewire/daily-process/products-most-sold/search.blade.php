<div class="flex">
    <div class="mt-3">
        @include('livewire.daily-process.products-most-sold.start_date')
    </div>

    <div class="mt-3">
        @include('livewire.daily-process.products-most-sold.end_date')
    </div>

    <div class="mt-9 ml-5">
      <button type="button" class="boton-azul" wire:click="clear_fields()"><i class="fa-solid fa-broom"></i> Limpiar campos</button>
    </div>
</div>
