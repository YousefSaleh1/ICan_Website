<?php

namespace App\Http\Traits;

use App\Http\Requests\EmailRequest;
use App\Models\Email;
use Illuminate\Http\Request;


trait CreateTrait
{
    public function StoreEmail(Request $request)
    {
        $email = Email::creat($request->email);
        return $email;
    }
}
