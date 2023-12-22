<?php

namespace App\Models;

use App\Models\Photo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mosab\Translation\Database\TranslatableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends TranslatableModel
{
    use HasFactory,SoftDeletes;

    protected $fillable = [

        'photo_id',
        'facebook',
        'linkedin',
        'website',
    ];
    protected $translatable = [
        'name',
        'career',
    ];

     /**
     * Get the user associated with the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function photo()
    {
        return $this->belongsTo(Photo::class,'photo_id', 'id');
    }
}
