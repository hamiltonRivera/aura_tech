<div class="ml-5 mt-4">
    <div class="lg:grid grid-cols-2 sm:grid-col-1">
        {{-- primer columna --}}
        <div>
            @include('livewire.admin.orders-providers.form')
        </div>

        {{-- segunda columna --}}
        <div>
             @include('livewire.admin.orders-providers.products') 
        </div>
    </div>

    {{-- Mover la tabla AQUÍ DENTRO del div principal --}}
     <div>
      @include('livewire.admin.orders-providers.table')
    </div> 
</div>