<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $recruteur = User::role('recruteur')->first();

        if($recruteur) {
            Job::create([
                'user_id' => $recruteur->id,
                'title' => 'Laravel Developer',
                'company' => 'Tech Solutions',
                'description' => 'Looking for a PHP expert to build amazing V2 apps.',
                'contract_type' => 'CDI',
                'image' => 'jobs/default.png',
            ]);

            Job::create([
                'user_id' => $recruteur->id,
                'title' => 'UI/UX Designer',
                'company' => 'Creative Agency',
                'description' => 'Design beautiful interfaces using Figma and Tailwind.',
                'contract_type' => 'Full-time',
                'image' => 'jobs/default.png',
            ]);
        } 
    }
}
