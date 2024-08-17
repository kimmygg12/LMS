<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\LoanBook;
use Illuminate\Support\Facades\Auth;

class StudentBookController extends Controller
{
    public function dashboard(Request $request)
    {
        $books = Book::all();
        $search = $request->input('search');
        $perPage = 5;

        if (Auth::guard('member')->check()) {
            $query = Book::query();

            if ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('isbn', 'LIKE', "%{$search}%")
                    ->orWhereHas('author', function ($query) use ($search) {
                        $query->where('name', 'LIKE', "%{$search}%");
                    });
            }

            $books = $query->paginate($perPage);

            return view('students.dashboard', compact('books'));
        }

        return redirect()->route('member.login');
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);
        return view('students.book-show-student', compact('book'));
    }

    public function showmember($id)
    {
        if (Auth::guard('member')->check()) {
            $member = Member::findOrFail($id);
            return view('students.show', compact('member'));
        }

        return redirect()->route('members.login');
    }
    public function showLoans($id)
    {
        if (Auth::guard('member')->check() && Auth::guard('member')->id() == $id) {
            $member = Member::findOrFail($id);
            $loans = LoanBook::where('member_id', $id)->with('book')->get();

            return view('students.loans', compact('member', 'loans'));
        }

        return redirect()->route('member.login');
    }


}