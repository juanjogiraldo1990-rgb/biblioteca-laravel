<?php

namespace Database\Seeders;

use App\Models\MoonshineUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RolesAndUsersSeeder extends Seeder
{
    public function run(): void
    {
        // El rol 1 (Admin) ya lo creó MoonShine al instalarse.
        // Creamos los roles 2 y 3.
        DB::table('moonshine_user_roles')->updateOrInsert(
            ['id' => 2],
            ['name' => 'Bibliotecario']
        );

        DB::table('moonshine_user_roles')->updateOrInsert(
            ['id' => 3],
            ['name' => 'Lector']
        );

        // Usuario Bibliotecario
        MoonshineUser::query()->updateOrCreate(
            ['email' => 'bibliotecario@biblioteca.com'],
            [
                'name' => 'Bibliotecario',
                'password' => Hash::make('Base1234+'),
                'moonshine_user_role_id' => 2,
            ]
        );

        // Usuario Lector
        MoonshineUser::query()->updateOrCreate(
            ['email' => 'lector@biblioteca.com'],
            [
                'name' => 'Lector',
                'password' => Hash::make('Base1234+'),
                'moonshine_user_role_id' => 3,
            ]
        );
    }
}
