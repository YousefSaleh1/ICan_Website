<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class partner extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = [
        'photo_id',
        'link'
    ];


    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }
}
