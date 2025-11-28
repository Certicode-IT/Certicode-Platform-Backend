<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Skill::create(['name' => 'PHP']);
        Skill::create(['name' => 'Laravel']);
        Skill::create(['name' => 'JavaScript']);
        Skill::create(['name' => 'React']);
        Skill::create(['name' => 'Python']);
        Skill::create(['name' => 'Django']);
    }
}
