<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Http\Resources\BlogResource;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\UploadPhotoTrait;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    use ApiResponseTrait, UploadPhotoTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::latest()->paginate(4);
        return $this->customeResponse(BlogResource::collection($blogs), "All Blogs", 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request)
    {
        $request->validated();
        DB::beginTransaction();
        try {
            $photo = $this->StorePhoto($request, 'Blogs');
            $input =  $request->input('content');
            $blog = Blog::create([
                'photo_id' => $photo->id,
                'title'    => $request->title,
                'content'  => $input
            ]);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        if ($blog) {
            return $this->customeResponse(new BlogResource($blog), 'Blog Created Successfully', 201);
        }
        return $this->customeResponse(null, 'Blog didn\'t Create', 404);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        if ($blog) {
            return $this->customeResponse(new BlogResource($blog), 'ok', 200);
        }
        return $this->customeResponse(null, 'Blog not found', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogRequest $request, Blog $blog)
    {
        if ($blog) {
            DB::beginTransaction();
            try {
                if (!empty($request->photo)) {

                    $photo = $this->StorePhoto($request, 'Blogs');
                    $photo_id = $photo->id;
                } else {
                    $photo_id = $blog->photo_id;
                }
                $input =  $request->input('content');
                $blog->update([
                    'title' => $request->title,
                    'content' => $input,
                    'photo_id' => $photo_id,
                ]);
                DB::commit();
            } catch (\Throwable $e) {
                DB::rollBack();
                throw $e;
            }
            return $this->customeResponse(new BlogResource($blog), "Blog Updated Successfuly", 200);
        }
        return $this->customeResponse(null, "Blog not found", 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if ($blog) {
            $blog->delete();
            return $this->customeResponse(' ', 'Blog deleted successfully', 200);
        }
        return $this->customeResponse(null, 'Blog not found', 400);
    }
}
