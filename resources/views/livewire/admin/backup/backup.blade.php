<div>
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Gestión de Backups</h2>


        <div class="grid grid-cols-1 gap-6">
            <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Crear y Descargar Backup</h3>
                <p class="text-gray-600 mb-4">Genera un backup solo de la base de datos y lo descarga automáticamente a tu computadora.</p>
                <button wire:click="backupAndDownload" class="boton-azul w-full">
                    Crear y Descargar Backup
                </button>
            </div>
        </div>

        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Información</h3>
            <ul class="list-disc list-inside text-gray-600 space-y-2">
                <li>Se recomienda crear backups regularmente para evitar pérdida de datos</li>
                <li>Para restaurar, contacta al administrador del sistema</li>
            </ul>
        </div>
    </div>

@push('scripts')
<script>
    window.addEventListener('backupReady', event => {
        if (event.detail && event.detail.url) {
            window.location.href = event.detail.url;
        }
    });
</script>
@endpush
</div>
