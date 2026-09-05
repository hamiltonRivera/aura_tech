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
    $wire.on('descargarPdf', () => {
        // Creamos un iframe invisible para que el navegador descargue el PDF en segundo plano
        const iframe = document.createElement('iframe');
        iframe.style.display = 'none';
        iframe.src = "{{ route('proforma.pdf') }}";
        document.body.appendChild(iframe);

        // Limpiamos el iframe del DOM después de unos segundos para mantener limpio el código
        setTimeout(() => {
            document.body.removeChild(iframe);
        }, 10000);
    });
</script>
@endscript
