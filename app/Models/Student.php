<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_latin',
        'study_id',
        'category_id',
        'gender',
        'studentId',
        'phone',
        'image',
    ];

    // Define any relationships if necessary
    public function study()
    {
        return $this->belongsTo(Study::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
