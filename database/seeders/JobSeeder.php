<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Job::create([
            'title' => 'Backend Developer',
            'description' => 'Develop scalable backend APIs using Laravel.',
            'company_id' => 1,
            'visibility' => 'general',
            'location' => 'Cebu City',
            'employment_type' => 'full-time',
            'salary_range' => 'PHP 25,000 - 40,000',
        ]);

        Job::create([
            'title' => 'Frontend Developer',
            'description' => 'Build interactive UI components using React.',
            'company_id' => 2,
            'visibility' => 'company_only',
            'location' => 'Makati City',
            'employment_type' => 'full-time',
            'salary_range' => 'PHP 30,000 - 45,000',
        ]);

        Job::create([
            'title' => 'Full Stack Developer',
            'description' => 'Work on both frontend and backend systems.',
            'company_id' => 3,
            'visibility' => 'general',
            'location' => 'Remote',
            'employment_type' => 'contract',
            'salary_range' => 'PHP 35,000 - 50,000',
        ]);
    }
}
