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

        return redirect()->route('members.index')->with('success', __('messages.member_created_successfully'));
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

        return redirect()->route('members.index')->with('success', __('messages.member_updated_successfully'));
    }
    public function destroy($id)
    {
        $member = Member::findOrFail($id);

        // Check if the user is an admin
        if (Auth::check() && Auth::user()->usertype === 'admin') {
            if ($member->image && Storage::exists($member->image)) {
                Storage::delete($member->image);
            }
            $member->delete();

            return redirect()->route('members.index')->with('success', __('messages.member_deleted_successfully'));
        } else {
            return redirect()->route('members.index')->with('error', __('messages.permission_denied'));
        }
    }

    private function generateMemberId()
    {
        $randomNumber = rand(10000, 99999);
        return 'NMU-' . $randomNumber;
    }
}
