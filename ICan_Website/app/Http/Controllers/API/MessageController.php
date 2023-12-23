<?php

namespace App\Http\Controllers\API;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Traits\CreateTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Resources\MessageResource;

class MessageController extends Controller
{
    use CreateTrait,ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = Message::all();
        if (!$messages) {
            return $this->customeResponse(null,"there is no message" , 401);
        }
        return $this->customeResponse(MessageResource::collection($messages) ,"All Retrieve messages Success" , 200)  ;

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MessageRequest $request)
    {
        $validate = $request->validated();
        DB::beginTransaction();
        try {
            $email = $this->StoreEmail($request->email);
            $input =  $request->input('body');
            $message = Message::create([
                'name'     => $request->name,
                'body'      => $input,
                'email_id'  => $email->id,
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        if ($message) {
            return $this->customeResponse(new MessageResource($message), 'Successful', 200);
        }
        return $this->customeResponse(null, 'not found', 404);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $message = Message::find($id);

        if (!$message) {
            return $this->customeResponse(null, 'Message Not Found!', 404);
        }
        return $this->customeResponse(new MessageResource($message), 'Successful.', 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Message = Message::find($id);

        if (!$Message) {
            return $this->customeResponse(null, 'Message Not Found!', 401);
        }

        $Message->delete();

        return $this->customeResponse("", 'Deleted Message Successfully.', 200);
    }
}

