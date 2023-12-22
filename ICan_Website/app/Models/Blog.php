<?php

namespace App\Models;

use App\Models\Photo;
use Illuminate\Database\Eloquent\Model;
use Mosab\Translation\Database\TranslatableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends TranslatableModel
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'photo_id',
        'content',
    ];
    protected $translatable = [
        'title',
    ];

    public function photo()
    {
        return $this->belongsTo(Photo::class,'photo_id', 'id');
    }
}
