<div>
    <div class="lg:grid grid-cols-4 sm:grid-col-1 ml-4 mb-3">
        {{-- primera columna --}}
        <div>
          @include('livewire.daily-process.proformas.columns.first')
        </div>

        {{-- segunda columna --}}
        <div>
          @include('livewire.daily-process.proformas.columns.second')
        </div>

        {{-- tercera columna --}}
        <div>
          @include('livewire.daily-process.proformas.columns.third')
        </div>

        {{-- cuarta columna --}}
        <div>
          @include('livewire.daily-process.proformas.columns.fourth')
        </div>
    </div>

    {{-- tabla --}}
    <div>
     @include('livewire.daily-process.proformas.table')
    </div>
</div>

@script
<script>
    $wire.on('abrirPdf', () => {
        window.open("{{ route('proforma.pdf') }}", "_blank");
    });
</script>
@endscript
