<div>
    <div class="lg:grid grid-cols-3 sm:grid-col-1" wire:key="{{ $selected_id ?? 'new' }}">
        {{-- primer columna --}}
        <div>
            @include('livewire.daily-process.combos.combos_e_u_d_columns.first')
        </div>

        {{-- segunda columna --}}
        @if ($comboSel)
            <div>
                @include('livewire.daily-process.combos.combos_e_u_d_columns.second')
            </div>
        @endif


        {{-- tercera columna --}}
        @if ($comboSel)
            <div>
                @include('livewire.daily-process.combos.combos_e_u_d_columns.third')
            </div>
        @endif
    </div>

    {{-- buscador --}}
    <div class="ml-5 mb-3 mt-3">
        <label for="search" class="form-label">Buscador sensible</label>
        @include('livewire.daily-process.combos.search_combo')
    </div>

    <div>
        @include('livewire.daily-process.combos.table_combo')
    </div>
</div>
