<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function explanation()
    {
        return $this->hasOne(Explanation::class, 'question_id');
    }

    public function testResults()
    {
        return $this->hasMany(TestResult::class);
    }
}
