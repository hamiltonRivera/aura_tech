<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //creando roles
        $role1 = Role::create(['name' =>'Administrador']);
        $role2 = Role::create(['name' =>'Desarrollador']);
        $role3 = Role::create(['name' =>'Caja']);
        $role4 = Role::create(['name' => 'Sin Rol']);

       //creando permisos y relacionandolos con los roles
       Permission::create(['name' => 'administrador'])->syncRoles([$role1, $role2]);
       Permission::create(['name'=> 'procesos.diarios'])->syncRoles([$role1,$role2, $role3]);

       //creando usuario
       User::create(
        [
            'name' => 'Hamilton Rivera',
            'email' => 'rivera.hamilton@outlook.es',
            'password' =>bcrypt('admin')
        ]
    )->assignRole('Desarrollador');
    }
}
