<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Services\JobService;
use Illuminate\Http\Request;

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

    public function visibleJobs(Request $request){
        $user = $request->user();
        return $this->jobService->getVisibleJob($user);
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

    public function recommendedCourses($id){
        return $this->jobService->recommendCourses($id);
    }


}
