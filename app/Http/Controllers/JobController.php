<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Models\Job;
use App\Services\JobService;

 
class JobController extends Controller
{
    protected $jobService;

    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
    }

    //display all jobs
    public function index(){
        return  $this->jobService->getALlJobs();
    }
    
    //display single jobb
    public function show($id){
        return  $this->jobService->getJob($id);
    }

    //create job
    public function store(StoreJobRequest $request){
        return  $this->jobService->createJob($request->validated());
    }

    //update job
    public function update(UpdateJobRequest $request, $id){
        return  $this->jobService->updateJob($request->validated(),$id);
    }

    //delete job
    public function destroy($id){
        return $this->jobService->deleteJob($id);
    }

    public function recommendedCourses($id){}


}
