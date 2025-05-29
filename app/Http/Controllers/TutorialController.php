<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TutorialController extends Controller
{
    // Admin Views
    public function index(Request $request)
    {
        $tutorials = Tutorial::query();

        // Apply search filters
        if ($request->has('title') && $request->title) {
            $tutorials->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->has('category') && $request->category) {
            $tutorials->where('category_id', $request->category);
        }

        $tutorials = $tutorials->with('category')->get();
        $categories = Category::all(); // For the category dropdown in the search form

        return view('tutorials.index', compact('tutorials', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('tutorials.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'link' => 'required|url',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('tutorials', 'public');
        }

        Tutorial::create($data);
        return redirect()->route('tutorials.index')->with('success', 'Tutorial created successfully.');
    }

    public function edit(Tutorial $tutorial)
    {
        $categories = Category::all();
        return view('tutorials.edit', compact('tutorial', 'categories'));
    }

    public function update(Request $request, Tutorial $tutorial)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'link' => 'required|url',
                'category_id' => 'required|exists:categories,id',
                'image' => 'nullable|image|max:2048',
            ]);

            $data = $request->all();
            if ($request->hasFile('image')) {
                // Delete old image if it exists
                if ($tutorial->image && Storage::disk('public')->exists($tutorial->image)) {
                    Storage::disk('public')->delete($tutorial->image);
                }
                $data['image'] = $request->file('image')->store('tutorials', 'public');
            }

            $tutorial->update($data);
            return redirect()->route('tutorials.index')->with('success', 'Tutorial updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('tutorials.index')->with('error', 'Failed to update tutorial: ' . $e->getMessage());
        }
    }

    public function destroy(Tutorial $tutorial)
    {
        try {
            // Delete image if it exists
            if ($tutorial->image && Storage::disk('public')->exists($tutorial->image)) {
                Storage::disk('public')->delete($tutorial->image);
            }

            $tutorial->delete();
            return redirect()->route('tutorials.index')->with('success', 'Tutorial deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('tutorials.index')->with('error', 'Failed to delete tutorial: ' . $e->getMessage());
        }
    }

    // API Methods
    public function apiIndex(Request $request)
    {
        $tutorials = Tutorial::query();
        if ($request->has('category_id')) {
            $tutorials->where('category_id', $request->category_id);
        }
        return $tutorials->get();
    }
}