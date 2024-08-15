<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\LoanBook;
use App\Models\ApprovedBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * Handle the reservation of a book.
     */
    public function reserve(Request $request)
    {
        // Validate the request
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
            // 'reservation_date' => 'required|date',
        ]);

        $book = Book::find($request->book_id);

        // Check if the book is available for reservation
        if (!$book || $book->quantity < 1) {
            return redirect()->back()->with('error', 'The book is not available for reservation.');
        }

        // Generate a unique reservation number
        $reservationNumber = $this->generateReservationNumber();

        // Create the reservation
        LoanBook::create([
            'book_id' => $book->id,
            'member_id' => $request->member_id,
            // 'reservation_date' => $request->reservation_date,
            'invoice_number' => $reservationNumber,
            'status' => 'reserved',
        ]);
        return redirect()->back()->with('success', 'Your reservation has been successful.');
        // return redirect()->route('members.dashboard')->with('success', 'Book reserved successfully.');
    }
    public function showReservedBooks()
    {
        // Fetch the reserved books for the logged-in member
        $reservedBooks = LoanBook::where('member_id', Auth::guard('member')->id())
            ->where('status', 'reserved')
            ->with('book') // Eager load the book relation
            ->get();

        return view('members.reserved-books', compact('reservedBooks'));
    }
    private function generateReservationNumber()
    {
        $randomNumber = rand(10000, 99999);
        return 'INV-' . $randomNumber;
    }

}
