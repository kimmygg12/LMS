<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'member_id',
        'price',
        'loan_date',
        'due_date',
        'invoice_number',
        'status',
        'renew_date',
        'fine',
        'fine_reason',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    public function bookCopy()
    {
        return $this->belongsTo(BookCopy::class);
    }
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
    public function history()
    {
        return $this->hasMany(LoanBookHistory::class);
    }
}
