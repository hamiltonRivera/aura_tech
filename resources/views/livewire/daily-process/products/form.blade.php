<div class="lg:grid grid-cols-4 sm:grid-col-1" wire:key="{{ $selected_id ?? 'new' }}">
    {{-- primer culmna --}}
    <div>
      @include('livewire.daily-process.products.form.firstColumn')
   </div>

  {{-- segunda columna --}}
   <div>
    @include('livewire.daily-process.products.form.secondColumn')
   </div>
    {{-- tercer columna --}}
   <div>
    @include('livewire.daily-process.products.form.thirdColumn')
   </div>
    {{-- cuarta columna --}}
   <div>
    @include('livewire.daily-process.products.form.fourthColumn')
   </div>
</div>

