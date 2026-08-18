<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create(
            [
                'name' => 'Hamilton Rivera',
                'email' => 'rivera.hamilton@outlook.es',
                'password' =>bcrypt('admin')
            ]
        );
    }
}
