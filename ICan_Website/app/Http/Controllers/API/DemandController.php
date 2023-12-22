<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DemandRequest;
use App\Http\Resources\DemandResource;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\CreateTrait;
use App\Models\Demand;
use Illuminate\Support\Facades\DB;

class DemandController extends Controller
{
    use ApiResponseTrait, CreateTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $demands = Demand::all();
        return $this->customeResponse(DemandResource::collection($demands), "All Demands", 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DemandRequest $request)
    {
        $request->validated();
        DB::beginTransaction();
        try {
            $email = $this->StoreEmail($request->email);
            $input =  $request->input('serviece_details');
            $demand = Demand::create([
                'email_id'         => $email->id,
                'serviece_name'    => $request->serviece_name,
                'serviece_details' => $input
            ]);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        if ($demand) {
            return $this->customeResponse(new DemandResource($demand), 'Demand Created Successfully', 201);
        }
        return $this->customeResponse(null, 'Demand didn\'t Create', 404);
    }

    /**
     * Display the specified resource.
     */
    public function show(Demand $demand)
    {
        if ($demand) {
            return $this->customeResponse(new DemandResource($demand), 'ok', 200);
        }
        return $this->customeResponse(null, 'Demand not found', 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Demand $demand)
    {
        if ($demand) {
            $demand->delete();
            return $this->customeResponse(' ', 'Demand deleted successfully', 200);
        }
        return $this->customeResponse(null, 'Demand not found', 400);
    }
}
