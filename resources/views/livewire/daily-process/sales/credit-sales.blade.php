<div>
    <div class="lg:grid grid-cols-4 sm:grid-col-1 ml-4 mb-3">
       {{-- primer columna --}}
       <div>
        @include('livewire.daily-process.sales.column-credit.first-column')
       </div>

       {{-- segunda columna --}}
       <div>
         @include('livewire.daily-process.sales.column-credit.second-column')
       </div>

       {{-- tercer columna --}}
       <div>
         @include('livewire.daily-process.sales.column-credit.third-column')
       </div>

       {{-- cuarta columna --}}
       <div class="ml-2">
         @include('livewire.daily-process.sales.column-credit.fourth-column')
       </div>
    </div>

    {{-- tabla --}}
    <div>
     @include('livewire.daily-process.sales.credit_table_sale')
    </div>
 </div>
