<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'title',
        'description',
        'company_id',
        'visibility',
        'location',
        'employment_type',
        'salary_range'
    ];

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function skills(){
        return $this->belongsToMany(Skill::class);
    }
}
