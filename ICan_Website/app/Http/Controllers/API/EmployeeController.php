<?php

namespace App\Http\Controllers\API;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\PhotoResource;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Resources\EmployeeResource;
use App\Http\Traits\UploadPhotoTrait;

class EmployeeController extends Controller
{
    use ApiResponseTrait,UploadPhotoTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::all();
        if (!$employees) {
            return $this->customeResponse(null,"there is no employees" , 401);
        }
        return $this->customeResponse(EmployeeResource::collection($employees) ,"All Retrieve employees Success" , 200)  ;

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {
        $validate = $request->validated();
        DB::beginTransaction();
        try {
            $photo = $this->StorePhoto($request,'Employee');
            $employee = Employee::create([
                'name'      => $request->name,
                'career'    => $request->career,
                'facebook'  => $request->facebook,
                'linkedin'  => $request->linkedin,
                'website'   => $request->website,
                'photo_id'  => $photo->id,
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        if ($employee) {
            return $this->customeResponse(new EmployeeResource($employee), 'Successful', 201);
        }
        return $this->customeResponse(null, 'not found', 404);


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return $this->customeResponse(null, 'employee Not Found!', 404);
        }
        return $this->customeResponse(new EmployeeResource($employee), 'Deleted employee Successfully.', 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequest $request, string $id)
    {

        $validate = $request->validated();
        $employee = Employee::find($id);
        if (!$employee) {
            return $this->customeRespone(null, 'the employee not found.', 404);
        }
        DB::beginTransaction();
        try {
            if (!empty($request->photo)) {

                $photo = $this->StorePhoto($request,'Employee');
                $photo_id = $photo->id;
            } else {
                $photo_id = $employee->photo_id;
            }

            $employee->update([
                'name'      => $request->name,
                'career'    => $request->career,
                'facebook'  => $request->facebook,
                'linkedin'  => $request->linkedin,
                'website'   => $request->website,
                'photo_id'  => $photo_id,
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return $this->customeResponse(new EmployeeResource($employee), "employee Updated Successfuly", 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $employee = Employee::find($id);

        if (!$employee) {
            return $this->customeResponse(null, 'employee Not Found!', 401);
        }

        $employee->delete();

        return $this->customeResponse("", 'Deleted employee Successfully.', 200);
    }
}
