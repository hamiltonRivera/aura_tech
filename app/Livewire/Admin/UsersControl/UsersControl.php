<?php

namespace App\Livewire\Admin\UsersControl;

use Livewire\Component;
use App\Models\User;
use App\Models\ActivityLog;
use App\Models\Gasto;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
class UsersControl extends Component

{

    use WithPagination;

    public $search = '';

    public $selectedRole = [];
    // Variables para el Modal de Adelanto 

    public $isAdvanceModalOpen = false;
    public $advance_user_id;
    public $advance_user_name;
    public $advance_amount = 0;
    public $advance_date;

    public function mount()

    {

        $this->selectedRole = array_fill_keys(User::pluck('id')->toArray(), '');

        $this->advance_date = Carbon::now()->format('Y-m-d');
    }

    public function render()

    {

        $users = User::where('name', 'like', '%' . $this->search . '%')

            ->orWhere('email', 'like', '%' . $this->search . '%')

            ->paginate(8);

        return view('livewire.admin.users-control.users-control', [

            'users' => $users,

            'roles' => Role::all()

        ]);
    }

    public function refresh()

    {

        return redirect('/private/admin/userscontrol');
    }

    public function assignRoles()

    {
        foreach ($this->selectedRole as $userId => $roleName) {

            $user = User::find($userId);
            if ($user && $roleName) {

                $user->syncRoles([$roleName]);

                $newActivitie = new ActivityLog();

                $newActivitie->user_id = auth()->user()->id;

                $newActivitie->activity = "Cambio de rol";

                $newActivitie->detail = $user->name;

                $newActivitie->save();
            }
        }
        Alert::success('Usuarios', 'Usuario actualizado');

        return $this->refresh();
    }
    // --- FUNCIONES DEL MODAL DE ADELANTO --- 
    public function openAdvanceModal($userId)

    {

        $user = User::findOrFail($userId);

        $nombreRol = $user->roles->first() ? strtolower($user->roles->first()->name) : '';

        if (!in_array($nombreRol, ['caja', 'administrador'])) {

            return;
        }

        $this->advance_user_id = $user->id;

        $this->advance_user_name = $user->name;

        // CORRECCIÓN: Forzamos a null para que el input numérico salga en blanco siempre 

        $this->advance_amount = null;

        // Mantenemos la fecha de hoy, porque el dinero sale de la caja en este instante 

        $this->advance_date = \Carbon\Carbon::now()->format('Y-m-d');

        $this->isAdvanceModalOpen = true;
    }

    public function closeAdvanceModal()

    {

        $this->isAdvanceModalOpen = false;

        $this->reset(['advance_user_id', 'advance_user_name', 'advance_amount', 'advance_date']);
    }

    public function saveAdvance()

    {

        $this->validate([

            'advance_amount' => 'required|numeric|min:1',
            'advance_date' => 'required|date'

        ]);

        $user = User::findOrFail($this->advance_user_id);

        // CORRECCIÓN: Obtenemos lo que ya debía y le sumamos el nuevo adelanto 
        $saldoAnterior = (float) ($user->salary_advance ?? 0);
        $user->salary_advance = $saldoAnterior + (float) $this->advance_amount;
        $user->last_advance_date = $this->advance_date;
        $user->save();

        // Registramos la SALIDA DE DINERO FÍSICO en la caja (Tabla Gastos) 
        $expense = new Gasto();
        $expense->descripcion = 'Adelanto de salario otorgado a: ' . $user->name;
        $expense->fecha = $this->advance_date;
        $expense->monto = $this->advance_amount;
        $expense->tipo_gasto = 'Adelantos de Salario';
        $expense->save();

        // Historial de actividad 
        $activity = new ActivityLog();
        $activity->user_id = auth()->user()->id;
        $activity->activity = "Adelanto de Salario Registrado";
        $activity->detail = $user->name . " - Monto: " . $this->advance_amount;
        $activity->save();
        $this->closeAdvanceModal();
        Alert::success('Éxito', 'Adelanto registrado y sumado a la deuda total');
        return $this->refresh();
    }
}
