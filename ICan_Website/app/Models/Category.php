<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mosab\Translation\Database\TranslatableModel;

class Category extends TranslatableModel
{
    use HasFactory , SoftDeletes;
    protected $fillable = [
        'photo_id'
    ];

    protected $translatable = [
        'title',
        'details',
    ];


    public function photo()
    {
        return $this->belongsTo(Photo::class, 'photo_id', 'id');
    }

    public function company_jobs()
    {
        // return $this->belongsToMany(CompanyJob::class, 'job_categories', 'category_id', 'company_job_id');
        return $this->belongsToMany(CompanyJob::class, 'job_categories');
    }
}
