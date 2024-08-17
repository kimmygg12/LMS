<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
        'pay_date',
        'fine',
        'fine_reason',
        'quantity',
    ];
    protected $casts = [
        'loan_date' => 'datetime',
        'due_date' => 'datetime',
        'renew_date' => 'datetime',
        'pay_date' => 'datetime',
    ];
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
    public function history()
    {
        return $this->hasMany(LoanBookHistory::class);
    }
    public function study()
    {
        return $this->belongsTo(Study::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }


}
