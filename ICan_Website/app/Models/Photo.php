<?php

namespace App\Models;

use App\Models\Blog;
use App\Models\Slider;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function slider()
    {
        return $this->hasOne(Slider::class, 'photo_id', 'id');
    }
    public function blog()
    {
        return $this->hasOne(Blog::class, 'photo_id', 'id');
    }
    public function employee()
    {
        return $this->hasOne(Employee::class, 'photo_id', 'id');
    }
}
