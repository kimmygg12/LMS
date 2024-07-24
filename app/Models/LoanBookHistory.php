<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanBookHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'book_id',
        'member_id',
        'price',
        'loan_date',
        'invoice_number',
        'renew_date',
        'fine',
        'fine_reason'
    ];
    public function loans()
    {
        return $this->belongsTo(LoanBook::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
