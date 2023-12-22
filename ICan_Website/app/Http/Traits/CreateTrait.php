<?php

namespace App\Http\Traits;

use App\Http\Requests\EmailRequest;
use App\Models\Email;
use Illuminate\Http\Request;


trait CreateTrait
{
    public function StoreEmail($request)
    {
        $email = Email::create([
            'email' => $request
        ]);
        return $email;
    }
}
