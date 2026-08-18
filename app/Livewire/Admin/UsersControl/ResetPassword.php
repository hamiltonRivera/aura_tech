<?php

namespace App\Livewire\Admin\UsersControl;

use Livewire\Component;
use App\Models\User;
use App\Models\ActivityLog;
use Livewire\WithPagination;
use RealRashid\SweetAlert\Facades\Alert;
class ResetPassword extends Component
{

     use WithPagination;

    public $search = '', $selected_id, $name, $email, $password;

    public function render()
    {
        $users = User::where('name', 'like', '%' . $this->search . '%')
        ->orWhere('email', 'like', '%' . $this->search . '%')->paginate(8);
        return view('livewire.admin.users-control.reset-password', compact('users'));
    }

    public function refresh()
    {
        return redirect('/private/admin/resetPassword');
    }

    public function edit($id)
    {
      $record = User::findOrFail($id);
      $this->selected_id = $id;
      $this->name = $record->name;
      $this->email = $record->email;
      $this->password = $record->password;

    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if($this->selected_id)
        {
            $record = User::findOrFail($this->selected_id);
            $record->update([
                'name' =>($this->name),
                'email' =>($this->email),
                'password' => bcrypt($this->password)
            ]);

             $newActivitie = new ActivityLog();
            $newActivitie->user_id = auth()->user()->id;
            $newActivitie->activity = "Registro Modificado - reseteo de contraseña";
            $newActivitie->detail = $record->name;
            $newActivitie->save();
           Alert::success('Contraseña', 'Contraseña actualizada exitosamente');
           $this->refresh();
        }
    }
}
