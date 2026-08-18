<?php

namespace App\Livewire\Admin\Backup;

use Livewire\Component;
use Spatie\Backup\BackupDestination\BackupDestination;
use Spatie\DbDumper\Databases\MySql;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class Backup extends Component
{

    public function backupAndDownload()
    {
        // Solo base de datos
        Artisan::call('backup:run', [
            '--only-db' => true,
            '--disable-notifications' => true,
        ]);

        // Buscar el último archivo .zip en storage/app/Laravel (por defecto de Spatie)
        $files = collect(Storage::disk('local')->files('Laravel'))
            ->filter(function ($file) {
                return str_ends_with($file, '.zip');
            })
            ->sortDesc();

            if ($files->isEmpty()) {
                $this->dispatch('swal', [
                    'title' => 'Error',
                    'text' => 'No se encontró ningún backup de base de datos.',
                    'icon' => 'error',
                ]);
                return;
        }

        $latest = $files->first();
            // Emitir evento con la ruta de descarga
            $filename = basename($latest);
            $downloadUrl = route('admin.download-backup', ['filename' => $filename]);
            $this->dispatch('backupReady', ['url' => $downloadUrl])->toBrowser();
    }

    public function render()
    {
        return view('livewire.admin.backup.backup');
    }
}
