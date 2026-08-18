<div class="lg:grid grid-cols-3 sm:grid-col-1">
    @foreach ($settings as $setting)
        {{-- primer columna --}}
        <div>
            @include('livewire.admin.settings.edit.first')
        </div>

        {{-- segunda columna --}}
        <div>
            @include('livewire.admin.settings.edit.second')
        </div>

        {{-- tercer fila --}}
        <div>
            @include('livewire.admin.settings.edit.third')
        </div>
    @endforeach

</div>
