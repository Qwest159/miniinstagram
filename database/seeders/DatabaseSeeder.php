<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // On supprime les anciennes images de test
        $images = Storage::disk('public')->files('images');
        Storage::disk('public')->delete($images);

        $this->call([
            RolesTableSeeder::class,
            UsersTableSeeder::class,
        ]);
    }
}
