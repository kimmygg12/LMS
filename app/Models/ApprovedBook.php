<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovedBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'member_id',
        'approval_date',
        'invoice_number',
    ];
}
