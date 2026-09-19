<?php

namespace App\Livewire\Admin\UsersControl;

use Livewire\Component;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;
use App\Models\ActivityLog;
class AdminUser extends Component
{

    public $name, $email, $salary;
    public function render()
    {
        return view('livewire.admin.users-control.admin-user');
    }

    public function refresh()
    {
        return redirect('/private/admin/userscontrol');
    }

    public function store()
    {
         //creación del usuario
         if(empty($this->email))
         {
            session()->flash('message', 'Uno o ambos campos están vaciós.');
            return false;
         }else{
            $user = User::create([
                'name' => ucfirst(strtolower($this->name)),
                'email' => strtolower($this->email),
                'password' => bcrypt('Sistema123@'),  // Contraseña genérica
                'salary' => $this->salary
            ]);

            // Obtener el rol "Docente" usando el nombre del rol
            $Role = Role::where('name', 'Administrador')->first();

            // Asignar el rol de docente al usuario
            $user->assignRole($Role);

            $newActivitie = new ActivityLog();
            $newActivitie->user_id = auth()->user()->id;
            $newActivitie->activity = "Nuevo Registro - Usuario admin";
            $newActivitie->detail = $user->name;
            $newActivitie->save();

            Alert::success('Usuario', 'Usuario registrado exitosamente');
            $this->refresh();
         }

    }
}
