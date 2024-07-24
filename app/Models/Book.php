<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'author_id', 'isbn', 'publication_date', 'description','status'];



    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function otherAuthors()
    {
        return $this->belongsToMany(Author::class, 'other_authors');
    }
    public function copies()
    {
        return $this->hasMany(BookCopy::class);
    }
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    public function history()
    {
        return $this->hasMany(LoanBookHistory::class);
    }
 
}
