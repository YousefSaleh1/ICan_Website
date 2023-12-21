<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demand extends Model
{
    use HasFactory;
    protected $fillable = [
        'email_id',
        'serviece_name',
        'serviece_details',
    ];

    public function email()
    {
        return $this->belongsTo(Email::class);
    }
}
