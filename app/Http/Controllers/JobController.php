<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class JobController extends Controller
{

    //display all jobs
    public function index(){
        $jobs = Job::with(['company','skills'])->get();
        return response()->json($jobs);
    }
    
    //display single jobb
    public function show($id){
        $job = Job::with(['company','skills'])->find($id);

        if(!$job){
            return response()->json(['message'=> 'Job with id ' . $id . ' not found'],404);
        }

        return response()->json($job);
    }

    //create job
    public function store(Request $request){

        if(!$request){
            return response()->json(['message'=> 'invalid ']);
        }


        $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'company_id' => 'required|exists:companies,id',
        'visibility' => 'required|in:general,company_only',
        'location' => 'nullable|string|max:255',
        'employment_type' => 'required|in:full-time,part-time,contract',
        'salary_range' => 'nullable|string|max:255',
        'skills' => 'nullable|array',
        'skills.*' => 'exists:skills,id',
    ]);


        $job = Job::create($request->except('skills'));
        if($request->has('skills')){
            $job->skills()->attach($request->skills);
        }


        return response()->json($job->load('skills','company'),201);


    }

    //update job
    public function update(Request $request, $id){

        //find the job with id
        $job = Job::find($id);

        //check if job exist otherwise return a message 
        if(!$job){
            return response()->json(['message'=>'Job with id '. $id . ' not found.'],404);
        }


        //validate the job
           $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'company_id' => 'sometimes|required|exists:companies,id',
            'visibility' => 'sometimes|required|in:general,company_only',
            'location' => 'nullable|string|max:255',
            'employment_type' => 'sometimes|required|in:full-time,part-time,contract',
            'salary_range' => 'nullable|string|max:255',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',
        ]);

        //update the job first except the skills
        $job->update($request->except('skills'));


        //check if request has skill and then update the job's skills with the new one 
        if($job->has('skills')){
            $job->skills()->sync($request->skills);
        }
        //return a response
        return response()->json($job->load('skills','company'));

    }

    public function destroy($id){
        // find the job
        $job = Job::find($id);

        //check if job exist otherwise return message
        if(!$job){
            return response()->json(['message'=>'Job with id '. $id . ' not found.']);
        }

        $job->delete();

        //return a response
        return response()->json([
            'success'=> 'true',
            'message'=> 'Job Deleted'
        ]);
    }

    public function recommendedCourses($id){}


}
