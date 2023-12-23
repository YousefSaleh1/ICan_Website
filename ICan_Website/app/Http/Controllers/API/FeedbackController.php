<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeedbackRequest;
use App\Http\Resources\FeedbackResource;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\CreateTrait;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
{
    use ApiResponseTrait , CreateTrait ;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feedbacks = Feedback::all();
        return $this->customeResponse(FeedbackResource::collection($feedbacks), "All Feedbacks", 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FeedbackRequest $request)
    {
        $request->validated();
        DB::beginTransaction();
        try {
            $email = $this->StoreEmail($request->email);
            $feedback = Feedback::create([
                'email_id'   => $email->id,
                'comment'    => $request->comment,
                'rate'       => $request->rate
            ]);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        if ($feedback) {
            return $this->customeResponse(new FeedbackResource($feedback), 'Feedback Created Successfully', 201);
        }
        return $this->customeResponse(null, 'Feedback didn\'t Create', 404);
    }

    /**
     * Display the specified resource.
     */
    public function show(Feedback $feedback)
    {
        if ($feedback) {
            return $this->customeResponse(new FeedbackResource($feedback), 'ok', 200);
        }
        return $this->customeResponse(null, 'Feedback not found', 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feedback $feedback)
    {
        if ($feedback) {
            $feedback->delete();
            return $this->customeResponse(' ', 'Feedback deleted successfully', 200);
        }
        return $this->customeResponse(null, 'Feedback not found', 400);
    }
}
