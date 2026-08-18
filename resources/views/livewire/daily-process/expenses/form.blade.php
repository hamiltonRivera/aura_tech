<div class="lg:grid grid-cols-3 sm:grid-col-1" >
    {{-- primer columna --}}
    <div>
      @include('livewire.daily-process.expenses.columns.first')
    </div>
    {{-- segunda columna --}}
    <div>
       @include('livewire.daily-process.expenses.columns.second')
    </div>

    {{-- tercer columna --}}
    <div>
       @include('livewire.daily-process.expenses.columns.third')
    </div>
   </div>
