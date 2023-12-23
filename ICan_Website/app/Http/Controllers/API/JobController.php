<?php

namespace App\Http\Controllers\API;

use App\Models\CompanyJob;
use Illuminate\Http\Request;
use App\Http\Requests\JobRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\JobResource;
use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\UploadPhotoTrait;

class JobController extends Controller
{
    use UploadPhotoTrait,ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = CompanyJob::all();
        if (!$jobs) {
            return $this->customeResponse(null,"there is no job" , 401);
        }
        return $this->customeResponse(JobResource::collection($jobs) ,"All Retrieve jobs Success" , 200)  ;

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobRequest $request)
    {
        $validate = $request->validated();
        DB::beginTransaction();
        try {
            $photo = $this->StorePhoto($request,'Jobs');

            $job = CompanyJob::create([
                'title' => $request->title,
                'photo_id' => $photo->id,
                'link' => $request->link,
            ]);
            if ($request->has('categories')) {
                $job->categories()->attach($request->input('categories'));
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        if ($job) {
            return $this->customeResponse(new JobResource($job), 'Successful', 200);
        }
        return $this->customeResponse(null, 'not found', 404);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $job = CompanyJob::find($id);

        if (!$job) {
            return $this->customeResponse(null, 'job Not Found!', 404);
        }
        return $this->customeResponse(new JobResource($job), 'Successful.', 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobRequest $request, string $id)
    {

        $validate = $request->validated();
        $job = CompanyJob::find($id);

        if (!$job) {
            return $this->customeRespone(null, 'the job not found.', 404);
        }

        DB::beginTransaction();

        try {
            if (!empty($request->photo)) {
                $photo = $this->StorePhoto($request, 'Jobs');
                $photo_id = $photo->id;
            } else {
                $photo_id = $job->photo_id;
            }

            $job->update([
                'title' => $request->title,
                'photo_id' => $photo_id,
                'link' => $request->link,
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return $this->customeResponse(new JobResource($job), "job Updated Successfully", 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $job = CompanyJob::find($id);

        if (!$job) {
            return $this->customeResponse(null, 'job Not Found!', 401);
        }

        $job->delete();

        return $this->customeResponse("", 'Deleted job Successfully.', 200);
    }
}

