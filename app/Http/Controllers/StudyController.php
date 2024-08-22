<?php

namespace App\Http\Controllers;

use App\Models\Study;
use Illuminate\Http\Request;

class StudyController extends Controller
{
    public function index()
    {
        $studies = Study::all();
        return view('studies.index', compact('studies'));
    }

    public function create()
    {
        return view('studies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        Study::create([
            'name' => $request->name,
        ]);
    
        return redirect()->route('studies.index')->with('success', __('messages.study_created'));
    }
    

    public function show(Study $study)
    {
        return view('studies.show', compact('study'));
    }

    public function edit(Study $study)
    {
        return view('studies.edit', compact('study'));
    }

    public function update(Request $request, Study $study)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $study->update([
            'name' => $request->name,
        ]);

        return redirect()->route('studies.index')->with('success', __('messages.study_updated'));
    }

    public function destroy(Study $study)
    {
        $study->delete();

        return redirect()->route('studies.index')->with('success', __('messages.study_deleted'));
    }
}
