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
            // Assuming you want to log history of all books that were deleted
            // and that you have access to the relevant member and loan data
            
            // You may need to adjust this part to fit your actual logic
            $loans = LoanBook::where('book_id', $book->id)->get(); // Adjust based on your actual LoanBook model
            
            foreach ($loans as $loan) {
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
            }
        });
    }
    protected $fillable = ['title', 'author_id', 'isbn', 'publication_date', 'cover_image', 'description','status'];


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
    public function handle()
{
    DB::table('loan_book_histories')
        ->whereNotIn('book_id', function($query) {
            $query->select('id')->from('books');
        })
        ->delete();
}
 
}
