<div class="lg:grid grid-cols-3 sm:grid-col-1" wire:key="{{ $selected_id ?? 'new' }}">
    {{-- primer columna --}}
    <div>
      @include('livewire.daily-process.clients.form.first')
    </div>

    {{-- segunda columna --}}
    <div>
      @include('livewire.daily-process.clients.form.second')
    </div>
  </div>
