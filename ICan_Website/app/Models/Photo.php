<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Photo extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable =[
        'photo'
    ];


    public function partner()
    {
        return $this->hasOne(partner::class, 'photo_id', 'id');
    }

    public function company_job()
    {
        return $this->hasOne(CompanyJob::class, 'photo_id', 'id');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'photo_id', 'id');
    }
}
