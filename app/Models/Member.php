<?php


namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Authenticatable
{
    use HasFactory;
    protected $table = 'members'; 
    protected $fillable = ['name', 'name_latin', 'gender', 'phone', 'image', 'study_id', 'category_id', 'memberId','password'];
    protected $hidden = ['password', 'remember_token'];
    public function loans()
    {
        return $this->hasMany(LoanBook::class);
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
    public function books()
    {
        return $this->hasMany(Book::class);
    }
    
}
