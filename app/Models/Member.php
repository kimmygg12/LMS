<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'name_latin',
        'gender',
        'phone',
        'address',
        'dob',
        'image',
        'memberId'
    ];
    public function loans()
    {
        return $this->hasMany(LoanBook::class);
    }
    public function history()
    {
        return $this->hasMany(LoanBookHistory::class);
    }

}
