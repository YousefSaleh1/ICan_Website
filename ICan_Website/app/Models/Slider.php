<?php

namespace App\Models;

use App\Models\Photo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mosab\Translation\Database\TranslatableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slider extends TranslatableModel
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'photo_id',
    ];

    public function photo()
    {
        return $this->belongsTo(Photo::class,'photo_id', 'id');
    }
}
