<?php

namespace App\Http\Traits;

use App\Http\Requests\EmailRequest;
use App\Models\Email;
use Illuminate\Http\Request;


trait CreateTrait
{
    public function StoreEmail($request)
    {
        $email = Email::where('email', $request)->first();
        if (empty($email)) {
            $email = Email::create([
                'email' => $request
            ]);
            return $email;
        }
        return $email;
    }
}
