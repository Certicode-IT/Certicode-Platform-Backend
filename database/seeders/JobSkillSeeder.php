<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class JobSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Backend Developer → PHP, Laravel
        $backendJob = Job::where('title', 'Backend Developer')->first();
        $backendJob->skills()->attach([
            Skill::where('name', 'PHP')->first()->id,
            Skill::where('name', 'Laravel')->first()->id,
        ]);

        // Frontend Developer → JavaScript, React
        $frontendJob = Job::where('title', 'Frontend Developer')->first();
        $frontendJob->skills()->attach([
            Skill::where('name', 'JavaScript')->first()->id,
            Skill::where('name', 'React')->first()->id,
        ]);

        // Full Stack Developer → PHP, Laravel, JavaScript, React
        $fullstackJob = Job::where('title', 'Full Stack Developer')->first();
        $fullstackJob->skills()->attach([
            Skill::where('name', 'PHP')->first()->id,
            Skill::where('name', 'Laravel')->first()->id,
            Skill::where('name', 'JavaScript')->first()->id,
            Skill::where('name', 'React')->first()->id,
        ]);
    }
}
