<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = [
        'email'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'email_id', 'id');
    }

    public function massage()
    {
        return $this->hasOne(Message::class, 'email_id', 'id');
    }

    public function demand()
    {
        return $this->hasOne(Demand::class, 'email_id', 'id');
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class, 'email_id', 'id');
    }


}
