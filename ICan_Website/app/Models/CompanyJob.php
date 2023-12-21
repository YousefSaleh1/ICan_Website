<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mosab\Translation\Database\TranslatableModel;

class CompanyJob extends TranslatableModel
{
    use HasFactory , SoftDeletes;
    protected $fillable = [
        'photo_id',
        'link'
    ];

    protected $translatable = [
        'title',
    ];


    public function photo()
    {
        return $this->belongsTo(Photo::class, 'photo_id', 'id');
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'job_categories', 'category_id', 'company_job_id');
    }
}
