<div>
    <div class="mb-3">
     @include('livewire.daily-process.products-most-sold.search')
    </div>

    @if(!$start_date || !$end_date)
        <div class="mb-3 p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded">
            Selecciona un rango de fechas para ver los productos más vendidos.
        </div>
    @endif

    <div>
       
        @include('livewire.daily-process.products-most-sold.table')

    </div>

</div>
