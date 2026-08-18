<div>
    <div class="ml-5 mb-3 mt-3">
        <input type="search" wire:model.live="search" class="buscador-corto" placeholder="Buscador sensible">
    </div>

    <div>
        @include('livewire.daily-process.products.in_stock_table')
    </div>
</div>
