<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Student;
use App\Models\Study;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with(['study', 'category']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('studentId', 'like', "%{$search}%")
                  ->orWhere('name_latin', 'like', "%{$search}%");
        }

        $students = $query->paginate(5);
        return view('students.index', compact('students'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $studies = Study::all();
        $categories = Category::all();
        return view('students.create', compact('studies', 'categories'));
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

        $student = new Student([
            'name' => $request->name,
            'name_latin' => $request->name_latin,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'study_id' => $request->study_id,
            'category_id' => $request->category_id,
            'studentId' => $this->generateStudentId(),
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('images/students', 'public');
            $student->image = $imagePath;
        }

        $student->save();

        return redirect()->route('students.index');
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);
        return response()->json([
            'studentId' => $student->studentId,
            'name' => $student->name,
            'name_latin' => $student->name_latin,
            'gender' => $student->gender,
            'phone' => $student->phone,
            'study_name' => $student->study->name,
            'category_name' => $student->category->name,
            'image' => $student->image ? asset($student->image) : null,
        ]);
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $studies = Study::all();
        $categories = Category::all();
        return view('students.edit', compact('student', 'studies', 'categories'));
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

        $student = Student::findOrFail($id);
        $student->name = $request->name;
        $student->name_latin = $request->name_latin;
        $student->gender = $request->gender;
        $student->phone = $request->phone;
        $student->study_id = $request->study_id;
        $student->category_id = $request->category_id;

        if ($request->hasFile('image')) {
            if ($student->image && Storage::exists($student->image)) {
                Storage::delete($student->image);
            }
            $image = $request->file('image');
            $imagePath = $image->store('images/students', 'public');
            $student->image = $imagePath;
        }

        $student->save();

        return redirect()->route('students.index');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        if ($student->image && Storage::exists($student->image)) {
            Storage::delete($student->image);
        }
        $student->delete();
        return redirect()->route('students.index');
    }

    private function generateStudentId()
    {
        $randomNumber = rand(10000, 99999);
        return 'STU-' . $randomNumber;
    }
}
