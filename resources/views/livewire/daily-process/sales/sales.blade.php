<div>
    <div class="lg:grid grid-cols-4 sm:grid-col-1 ml-4 mb-3">
       {{-- primer columna --}}
       <div>
        @include('livewire.daily-process.sales.columns.first')
       </div>

       {{-- segunda columna --}}
       <div>
         @include('livewire.daily-process.sales.columns.second')
       </div>

       {{-- tercer columna --}}
       <div>
         @include('livewire.daily-process.sales.columns.third')
       </div>

       {{-- cuarta columna --}}
       <div class="ml-2">
         @include('livewire.daily-process.sales.columns.fourth')
       </div>
    </div>

    {{-- tabla --}}
    <div>
     @include('livewire.daily-process.sales.table')
    </div>
 </div>
@script
<script>
    $wire.on('abrir-pdf', (event) => {
        // Obtenemos la URL de forma segura sin importar cómo llegue el parámetro
        const data = event[0] || event;
        const url = data.url;

        // Mostramos la animación / alerta con SweetAlert2
        Swal.fire({
            title: '¡Éxito!',
            text: 'Venta realizada exitosamente', // O el mensaje que corresponda según el módulo
            icon: 'success',
            timer: 2500,               // Se cierra sola a los 2.5 segundos (opcional)
            timerProgressBar: true,
            showConfirmButton: true,
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            // Cuando se cierre la alerta (por temporizador o por dar clic en Aceptar), abrimos el PDF
            if (url) {
                window.open(url, '_blank');
            }
        });
    });
</script>
@endscript
