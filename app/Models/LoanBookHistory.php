<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LoanBookHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'book_id',
        'member_id',
        'price',
        'loan_date',
        'due_date',
        'pay_date',
        'invoice_number',
        'renew_date',
        'fine',
        'fine_reason',
        'status'
    ];
    protected $casts = [
        'loan_date' => 'datetime',
        'pay_date' => 'datetime',
    ];
    protected $dates = ['loan_date', 'due_date', 'renew_date', 'pay_date'];
    public function loans()
    {
        return $this->belongsTo(LoanBook::class);
    }
    public function handle()
{
    DB::table('loan_book_histories')
        ->whereNotIn('book_id', function($query) {
            $query->select('id')->from('books');
        })
        ->delete();
}

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
