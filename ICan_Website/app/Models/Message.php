<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'email_id',
        'name',
        'body'
    ];


    public function email()
    {
        return $this->belongsTo(Email::class);
    }
}
