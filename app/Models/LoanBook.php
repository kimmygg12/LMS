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
    // public function isDueTomorrow()
    // {
    //     $tomorrow = now()->addDay()->startOfDay();
    //     return $this->due_date->is($tomorrow);
    // }

    // public function isRenewTomorrow()
    // {
    //     $tomorrow = now()->addDay()->startOfDay();
    //     return $this->renew_date && $this->renew_date->is($tomorrow);
    // }
    // public function isOverdue()
    // {
    //     return $this->due_date->isPast();
    // }

}
