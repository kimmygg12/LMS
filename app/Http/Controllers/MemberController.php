<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\LoanBook;
use App\Models\Member;
use App\Models\Study;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
class MemberController extends Controller
{
    public function dashboard(Request $request)
{
    // Get the search query from the request
    $search = $request->input('search');
    
    // Define the number of books to display per page
    $perPage = 5;

    // If there is a search query, filter the books based on title, ISBN, or author's name
    if ($search) {
        $books = Book::where('title', 'LIKE', "%{$search}%")
                     ->orWhere('isbn', 'LIKE', "%{$search}%")
                     ->orWhereHas('author', function($query) use ($search) {
                         $query->where('name', 'LIKE', "%{$search}%");
                     })
                     ->paginate($perPage);
    } else {
        // If there's no search query, retrieve all books with pagination
        $books = Book::paginate($perPage);
    }

    // Return the view with paginated books
    return view('members.dashboard', compact('books'));
}


    // Method to show the details of a specific book
    public function showBook($id)
    {
        $book = Book::with('author')->findOrFail($id);
        return view('members.details', compact('book'));
    }
    public function showReservedBooks($id)
    {
        // Ensure that only authenticated members can view their own reserved books
        if (Auth::guard('member')->check() && Auth::guard('member')->id() == $id) {
            $member = Member::findOrFail($id);
            $reservedBooks = LoanBook::where('member_id', $id)
                ->where('status', 'reserved') // Assuming 'reserved' is the status for reserved books
                ->with('book')
                ->get();

            return view('members.reserved_books', compact('member', 'reservedBooks'));
        }

        return redirect()->route('members.login');
    }
    public function index(Request $request)
    {
        $query = Member::with(['study', 'category']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('memberId', 'like', "%{$search}%")
                ->orWhere('name_latin', 'like', "%{$search}%")
                ->orWhereHas('category', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }

        $members = $query->orderBy('created_at', 'desc')->paginate(5);

        // Get the most recently created member
        $newMembers = Member::orderBy('created_at', 'desc')->limit(1)->get();

        return view('members.index', compact('members', 'newMembers'));
    }


    public function create()
    {
        $studies = Study::all();
        $categories = Category::all();
        return view('members.create', compact('studies', 'categories'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'name_latin' => 'nullable|string|max:255',
            'gender' => 'required|string|in:male,female',
            'phone' => 'nullable|string|max:15',
            'study_id' => 'required|exists:studies,id',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $member = new Member([
            'name' => $request->name,
            'name_latin' => $request->name_latin,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'study_id' => $request->study_id,
            'category_id' => $request->category_id,
            'memberId' => $this->generateMemberId(),
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/members'), $imageName);
            $member->image = 'images/members/' . $imageName;
        }
        $member->save();

        return redirect()->route('members.index');
        // return redirect()->back()->with('success', 'Member created successfully.');
    }
    public function show($id)
    {
        $member = Member::findOrFail($id);
        return response()->json([
            'memberId' => $member->memberId,
            'name' => $member->name,
            'name_latin' => $member->name_latin,
            'gender' => $member->gender,
            'phone' => $member->phone,
            'study_name' => $member->study->name,
            'category_name' => $member->category->name,
            'image' => $member->image ? asset($member->image) : null,
        ]);
    }
    public function showmember($id)
    {
        // Ensure that only authenticated members can view their own details
        if (Auth::guard('member')->check()) {
            $member = Member::findOrFail($id);
            return view('members.show', compact('member'));
        }

        return redirect()->route('members.login');
    }
    public function showLoans($id)
    {
        // Ensure that only authenticated members can view their own loans
        if (Auth::guard('member')->check() && Auth::guard('member')->id() == $id) {
            $member = Member::findOrFail($id);
            $loans = LoanBook::where('member_id', $id)->with('book')->get();

            return view('members.loans', compact('member', 'loans'));
        }

        return redirect()->route('members.login');
    }
    public function edit($id)
    {
        $member = Member::findOrFail($id);
        $studies = Study::all();
        $categories = Category::all();
        return view('members.edit', compact('member', 'studies', 'categories'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'name_latin' => 'nullable|string|max:255',
            'gender' => 'required|string|in:male,female',
            'phone' => 'nullable|string|max:15',
            'study_id' => 'required|exists:studies,id',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $member = Member::findOrFail($id);
        $member->name = $request->name;
        $member->name_latin = $request->name_latin;
        $member->gender = $request->gender;
        $member->phone = $request->phone;
        $member->study_id = $request->study_id;
        $member->category_id = $request->category_id;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/members'), $imageName);
            $member->image = 'images/members/' . $imageName;
        }

        $member->save();

        return redirect()->route('members.index');
    }
    // public function destroy($id)
    // {
    //     $member = Member::findOrFail($id);
    //     if ($member->image && file_exists(public_path($member->image))) {
    //         unlink(public_path($member->image));
    //     }
    //     $member->delete();
    //     return redirect()->route('members.index');
    //     // return redirect()->back();
    // }
    public function destroy($id)
    {
        $member = Member::findOrFail($id);

        // Check if the user is an admin
        if (Auth::check() && Auth::user()->usertype === 'admin') {
            if ($member->image && Storage::exists($member->image)) {
                Storage::delete($member->image);
            }
            $member->delete();

            return redirect()->route('members.index');
        } else {
            return redirect()->route('members.index')->with('error', 'You do not have permission to delete this member.');
        }
    }

    private function generateMemberId()
    {
        $randomNumber = rand(10000, 99999);
        return 'NMU-' . $randomNumber;
    }
}
