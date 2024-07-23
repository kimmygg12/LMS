<?php
namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $members = Member::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('memberId', 'like', "%{$search}%")
                    ->orWhere('name_latin', 'like', "%{$search}%");
            })
            ->get();
        return view('members.index', compact('members', 'search'));
    }
    public function search(Request $request)
    {
        $term = $request->get('term');
        $members = Member::where('name', 'LIKE', "%{$term}%")
                         ->get(['id', 'name as value']);
        return response()->json($members);
    }
    public function create()
    {
        return view('members.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'name_latin' => 'nullable|string|max:255',
            'gender' => 'required|string|in:male,female',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $member = new Member([
            'name' => $request->name,
            'name_latin' => $request->name_latin,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'address' => $request->address,
            'dob' => $request->dob,
            'memberId' => $this->generateMemberId(),
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/members'), $imageName);
            $member->image = 'images/members/' . $imageName;
        }
        $member->save();

        return redirect()->route('members.index')->with('success', 'Member created successfully.');
    }
    public function show($id)
    {
        $member = Member::findOrFail($id);
        return view('members.show', compact('member'));
    }
    public function edit($id)
    {
        $member = Member::findOrFail($id);
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'name_latin' => 'nullable|string|max:255',
            'gender' => 'required|string|in:male,female',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $member = Member::findOrFail($id);
        $member->name = $request->name;
        $member->name_latin = $request->name_latin;
        $member->gender = $request->gender;
        $member->phone = $request->phone;
        $member->address = $request->address;
        $member->dob = $request->dob;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/members'), $imageName);
            $member->image = 'images/members/' . $imageName;
        }

        $member->save();

        return redirect()->route('members.index')->with('success', 'Member updated successfully.');
    }
    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        if ($member->image && file_exists(public_path($member->image))) {
            unlink(public_path($member->image));
        }
        $member->delete();

        return redirect()->route('members.index')->with('success', 'Member deleted successfully.');
    }
    private function generateMemberId()
    {

        $randomNumber = rand(10000, 99999);


        return 'NMU-' . $randomNumber;
    }
}
