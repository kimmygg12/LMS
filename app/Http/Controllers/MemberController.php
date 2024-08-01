<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Member;
use App\Models\Study;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::with(['study', 'category']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('memberId', 'like', "%{$search}%")
                ->orWhere('name_latin', 'like', "%{$search}%")
                ->orWhere('category_id', 'like', "%{$search}%");
        }
        $members = $query->paginate(5);
        return view('members.index', compact('members'))->with('i', (request()->input('page', 1) - 1) * 5);
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
    if ($member->image && Storage::exists($member->image)) {
        Storage::delete($member->image);
    }
    $member->delete();
    return redirect()->route('members.index');
}


    private function generateMemberId()
    {
        $randomNumber = rand(10000, 99999);
        return 'NMU-' . $randomNumber;
    }
}
