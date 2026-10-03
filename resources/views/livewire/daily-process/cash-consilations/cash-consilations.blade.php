<div class="ml-5 mb-4 mt-3">
    <div class="lg:grid grid-cols-3 sm:grid-col-1">
       {{-- primer columna --}}
        <div class="ml-5 mb-4 mt-3">
          @include('livewire.daily-process.cash-consilations.columns.first')
        </div>
       {{-- segunda columna --}}
        <div class="ml-5 mb-4 mt-3">
          @include('livewire.daily-process.cash-consilations.columns.second')
        </div>

        {{-- tercera columna --}}
        <div class="ml-5 mb-4 mt-3">
          @include('livewire.daily-process.cash-consilations.columns.third')
        </div>
    </div>

    <div>
        @include('livewire.daily-process.cash-consilations.search')
    </div>

    <div>
        @include('livewire.daily-process.cash-consilations.table')
    </div>
</div>
