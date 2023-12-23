<?php

namespace App\Http\Controllers\API;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Http\Resources\SliderResource;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\UploadPhotoTrait;

class SliderController extends Controller
{
    use UploadPhotoTrait,ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::all();
        if (!$sliders) {
            return $this->customeResponse(null,"there is no sliders" , 401);
        }
        return $this->customeResponse(SliderResource::collection($sliders) ,"All Retrieve sliders Success" , 200)  ;

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SliderRequest $request)
    {
        $validate = $request->validated();
        $photo = $this->StorePhoto($request,'Slider');

        $slider = Slider::create([
            'photo_id' => $photo->id
        ]);
        if ($slider) {
            return $this->customeResponse(new SliderResource($slider), 'Successful', 200);
        }
        return $this->customeResponse(null, 'not found', 404);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $slider = Slider::find($id);

        if (!$slider) {
            return $this->customeResponse(null, 'employee Not Found!', 404);
        }
        return $this->customeResponse(new SliderResource($slider), 'Successful.', 200);

    }

    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slider = Slider::find($id);

        if (!$slider) {
            return $this->customeResponse(null, 'slider Not Found!', 401);
        }

        $slider->delete();

        return $this->customeResponse("", 'Deleted slider Successfully.', 200);
    }
}
