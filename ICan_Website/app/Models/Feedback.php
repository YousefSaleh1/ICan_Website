<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $fillable = [
        'email_id',
        'comment',
        'rate'
    ];


    public function email()
    {
        return $this->belongsTo(Email::class);
    }
}
