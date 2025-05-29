<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects (API or Web).
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $projects = Project::all(['id', 'title', 'description', 'image', 'link', 'created_at', 'updated_at']);
        if ($request->wantsJson()) {
            return response()->json(['data' => $projects], 200);
        }
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project (Web).
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created project (API or Web).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if ($image->isValid()) {
                $imagePath = $image->store('projects', 'public');
                $validated['image'] = $imagePath;
            } else {
                if ($request->wantsJson()) {
                    return response()->json(['error' => 'Invalid image upload'], 422);
                }
                return redirect()->back()->withErrors(['image' => 'Invalid image upload']);
            }
        }

        $project = Project::create($validated);

        if ($request->wantsJson()) {
            return response()->json(['data' => $project], 201);
        }
        return redirect()->route('projects.index')->with('success', 'Project created');
    }

    /**
     * Display a specific project (API).
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $project = Project::findOrFail($id, ['id', 'title', 'description', 'image', 'link', 'created_at', 'updated_at']);
        return response()->json(['data' => $project]);
    }

    /**
     * Show the form for editing a project (Web).
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        return view('projects.edit', compact('project'));
    }

    /**
     * Update a specific project (API or Web).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if ($image->isValid()) {
                // Delete old image if exists
                if ($project->image) {
                    Storage::disk('public')->delete($project->image);
                }
                $imagePath = $image->store('projects', 'public');
                $validated['image'] = $imagePath;
            } else {
                if ($request->wantsJson()) {
                    return response()->json(['error' => 'Invalid image upload'], 422);
                }
                return redirect()->back()->withErrors(['image' => 'Invalid image upload']);
            }
        }

        $project->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['data' => $project]);
        }
        return redirect()->route('projects.index')->with('success', 'Project updated');
    }

    /**
     * Delete a specific project (API or Web).
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }

        $project->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Project deleted']);
        }
        return redirect()->route('projects.index')->with('success', 'Project deleted');
    }
}