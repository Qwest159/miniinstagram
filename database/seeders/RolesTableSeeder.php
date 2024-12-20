<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // On crée les rôles
        \App\Models\Role::create([
            'name' => \App\Models\Role::ADMIN,
        ]);

        \App\Models\Role::create([
            'name' => \App\Models\Role::AUTHOR,
        ]);
    }
}
