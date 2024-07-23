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
            'study' => 'required|integer|unique:studies',
        ]);

        Study::create($request->all());

        return redirect()->route('studies.index')
                         ->with('success', 'Study year created successfully.');
    }

    public function edit(Study $study)
    {
        return view('studies.edit', compact('study'));
    }

    public function update(Request $request, Study $study)
    {
        $request->validate([
            'study' => 'required|integer|unique:studies,study,' . $study->id,
        ]);

        $study->update($request->all());

        return redirect()->route('studies.index')
                         ->with('success', 'Study year updated successfully.');
    }

    public function destroy(Study $study)
    {
        $study->delete();
        return redirect()->route('studies.index')
                         ->with('success', 'Study year deleted successfully.');
    }
}
