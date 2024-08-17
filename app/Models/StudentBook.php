<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentBook extends Model
{
    protected $fillable = [
        'student_id',
        'book_id',
    ];

    // Define the relationship to the Book model
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Define the relationship to the Student model
    public function student()
    {
        return $this->belongsTo(StudentBook::class);
    }
}
