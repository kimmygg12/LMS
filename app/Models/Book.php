<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Book extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected static function booted()
    {
        static::deleting(function ($book) {
            $loans = LoanBook::where('book_id', $book->id)->get(); 
    
            foreach ($loans as $loan) {
                // Validate required fields
                if (empty($loan->loan_date)) {
                    // Handle missing loan_date
                    continue; // Skip this loan record or handle it as needed
                }
    
                try {
                    \App\Models\LoanBookHistory::create([
                        'book_id' => $book->id,
                        'member_id' => $loan->member_id,
                        'price' => $loan->price,
                        'loan_date' => $loan->loan_date,
                        'due_date' => $loan->due_date,
                        'pay_date' => $loan->pay_date,
                        'invoice_number' => $loan->invoice_number,
                        'renew_date' => $loan->renew_date,
                        'fine' => $loan->fine,
                        'fine_reason' => $loan->fine_reason,
                        'status' => 'deleted'
                    ]);
                } catch (\Illuminate\Database\QueryException $e) {
                    if ($e->getCode() == '23000') {
                        // Handle duplicate entry error
                    } else {
                        // Handle other errors
                        throw $e;
                    }
                }
            }
        });
    }
    

    protected $fillable = ['title', 'author_id', 'isbn', 'publication_date', 'quantity', 'cover_image', 'description', 'status', 'returned_at'];


    protected $dates = ['deleted_at'];
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    public function history()
    {
        return $this->hasMany(LoanBookHistory::class);
    }
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
    public function handle()
    {
        DB::table('loan_book_histories')
            ->whereNotIn('book_id', function ($query) {
                $query->select('id')->from('books');
            })
            ->delete();
    }
    public function loanBooks()
    {
        return $this->hasMany(LoanBook::class);
    }

    public function loanBookHistories()
    {
        return $this->hasMany(LoanBookHistory::class);
    }
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
    
}