<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerRequest;
use App\Http\Resources\PartnerResource;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\UploadPhotoTrait;
use App\Models\partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartnerController extends Controller
{
    use ApiResponseTrait , UploadPhotoTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partners = partner::all();
        return $this->customeResponse(PartnerResource::collection($partners), "All Patrners", 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PartnerRequest $request)
    {
        $request->validated();
        DB::beginTransaction();
        try {
            $photo = $this->StorePhoto($request, 'Partners');
            $partner = partner::create([
                'photo_id' => $photo->id,
                'link'    => $request->link,
            ]);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        if ($partner) {
            return $this->customeResponse(new PartnerResource($partner), 'Partner Created Successfully', 201);
        }
        return $this->customeResponse(null, 'Partner didn\'t Create', 404);
    }

    /**
     * Display the specified resource.
     */
    public function show(partner $partner)
    {
        if ($partner) {
            return $this->customeResponse(new PartnerResource($partner), 'ok', 200);
        }
        return $this->customeResponse(null, 'Patner not found', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PartnerRequest $request, partner $partner)
    {
        if ($partner) {
            DB::beginTransaction();
            try {
                if (!empty($request->photo)) {

                    $photo = $this->StorePhoto($request, 'Partners');
                    $photo_id = $photo->id;
                } else {
                    $photo_id = $partner->photo_id;
                }
                $partner->update([
                    'link' => $request->link,
                    'photo_id' => $photo_id,
                ]);
                DB::commit();
            } catch (\Throwable $e) {
                DB::rollBack();
                throw $e;
            }
            return $this->customeResponse(new PartnerResource($partner), "Partner Updated Successfuly", 200);
        }
        return $this->customeResponse(null, "Partner not found", 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(partner $partner)
    {
        if ($partner) {
            $partner->delete();
            return $this->customeResponse(' ', 'Partner deleted successfully', 200);
        }
        return $this->customeResponse(null, 'Partner not found', 400);
    }
}
