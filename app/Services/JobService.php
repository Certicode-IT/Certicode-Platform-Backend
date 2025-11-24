<?php

namespace App\Services;

use App\Models\Job;
use Illuminate\Support\Arr;

class JobService
{
    public function getALlJobs(){
        $jobs =Job::with(['company','skills'])->get();
         
        return response()->json($jobs);
    }

    public function getVisibleJob($user){
        return Job::with(['company', 'skills'])
            ->where(function ($query) use ($user) {
                $query->where('visibility', 'general');  

                if ($user  && $user->company_id ) {
                    $query->orWhere(function ($q) use ($user) {
                        $q->where('visibility', 'company')
                        ->where('company_id', $user->company_id);  
                    });
                }
              })
             ->get();
    }

    public function getJob($id){
       $job = Job::with(['company','skills'])->find($id);

       if(!$job){
            return response()->json(['message'=> 'Job with id ' . $id . ' not found'],404);
        }

        return response()->json($job);
    }

    public function createJob(array $data){
        $job = Job::create($data);

        if (!empty($data['skills'])) {
            $job->skills()->sync($data['skills']);
        }

         return response()->json($job->load('skills','company'),201);
    }

     public function updateJob(array $data,$id){

        $job = Job::with(['company','skills'])->find($id);

        //check if job exist otherwise return a message 
        if (!$job) {
            return response()->json(['message' => 'Job with id'. $id . ' not found.'], 404);
        }

          //update the job first except the skills
        $job->update(Arr::except($data,'skills'));

         //check if request has skill and then update the job's skills with the new one 
        if(!empty($data['skills'])){
            $job->skills()->sync($data['skills']);
        }

         return response()->json($job->load('skills','company'));
    }


    public function deleteJob($id){
        // find the job
        $job = Job::with(['company','skills'])->find($id);

        //check if job exist otherwise return message
        if(!$job){
            return response()->json(['message'=>'Job with id '. $id . ' not found.'],404);
        }

        $job->delete();

        //return a response
        return response()->json([
            'success'=> 'true',
            'message'=> 'Job Deleted'
        ]);
    }

    public function recommendCourses($id){

        $job  = Job::find($id);

        if(!$job){
            return response()->json(['message','Job with id '. $id . ' not found'],404);
        }

        $description = strtolower($job->description);
        
        $courses = [];

        if(str_contains($description,'php') || str_contains($description,'laravel')){
            $courses[] = 'Laravel for begginers';
            $courses[] = 'Mastering PHP OOP';
        }
        
        if(str_contains($description,'frontend') || str_contains($description,'react')){
            $courses[] = 'Reactjs for begginers';
            $courses[] = 'Modern Javascript Course';
        }
        
        if(empty($courses)){
            $courses[] = 'General Programming course';
        }
        
        return response()->json([
            'job_id' => $id,
            'courses' => $courses
        ]);
    }

   
}
