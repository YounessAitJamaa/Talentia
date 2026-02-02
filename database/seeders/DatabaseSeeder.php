<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        $chercheur = User::factory()->create([
            'name' => 'Youness Chercheur',
            'email' => 'chercheur@gmail.com',
            'role' => 'chercheur'
        ]);
        $chercheur->assignRole('chercheur');

        $recruteur = User::factory()->create([
            'name' => 'Youness Recruteur',
            'email' => 'recruteur@gmail.com',
            'role' => 'recruteur'
        ]);
        $recruteur->assignRole('recruteur');

        User::factory(10)->create()->each(function($user){
            $user->assignRole('chercheur');
        });
    }
}
