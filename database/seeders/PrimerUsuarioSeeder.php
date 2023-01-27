<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class PrimerUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $contraseña = "12345678";
        $user = new User([
            "email" => "admin@gmail.com",
            "password" => Hash::make($contraseña),
            "name" => "NO BORRAR - Administrador",
            "phone" => "9999999999",
            "permiso" => "0",
            "status" => "1",
        ]);
        $user->saveOrFail();
    }
}
