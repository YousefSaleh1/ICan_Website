<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\UploadPhotoTrait;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    use ApiResponseTrait , UploadPhotoTrait ;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return $this->customeResponse(CategoryResource::collection($categories), "All Categories", 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $request->validated();
        DB::beginTransaction();
        try {
            $photo = $this->StorePhoto($request, 'Categories');
            $input =  $request->input('details');
            $category = Category::create([
                'photo_id' => $photo->id,
                'title'    => $request->title,
                'details'  => $input
            ]);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        if ($category) {
            return $this->customeResponse(new CategoryResource($category), 'Category Created Successfully', 201);
        }
        return $this->customeResponse(null, 'Category didn\'t Create', 404);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        if ($category) {
            return $this->customeResponse(new CategoryResource($category), 'ok', 200);
        }
        return $this->customeResponse(null, 'Category not found', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        if ($category) {
            DB::beginTransaction();
            try {
                if (!empty($request->photo)) {

                    $photo = $this->StorePhoto($request, 'Categories');
                    $photo_id = $photo->id;
                } else {
                    $photo_id = $category->photo_id;
                }
                $input =  $request->input('details');
                $category->update([
                    'title' => $request->title,
                    'details' => $input,
                    'photo_id' => $photo_id,
                ]);
                DB::commit();
            } catch (\Throwable $e) {
                DB::rollBack();
                throw $e;
            }
            return $this->customeResponse(new CategoryResource($category), "Category Updated Successfuly", 200);
        }
        return $this->customeResponse(null, "Category not found", 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category) {
            $category->delete();
            return $this->customeResponse(' ', 'Category deleted successfully', 200);
        }
        return $this->customeResponse(null, 'Category not found', 400);
    }
}
