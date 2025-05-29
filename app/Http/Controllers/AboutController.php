<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    /**
     * Display the About page.
     */
    public function index()
    {
        $about = About::first();
        if (!$about) {
            $about = About::create([
                'bio' => 'No bio available yet.',
                'skills' => [],
                'experience' => [],
                'education' => [],
                'hobbies' => 'No hobbies listed yet.',
                'image' => null,
            ]);
        }
        return view('about.index', compact('about'));
    }

    /**
     * Show the form for creating a new About entry.
     */
    public function create()
    {
        return view('about.create');
    }

    /**
     * Store a newly created About entry.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bio' => 'nullable|string',
            'skills' => 'nullable|array',
            'skills.*.*.category' => 'nullable|string|in:Front-End Development,Back-End Development,Tools & Others',
            'skills.*.*.name' => 'nullable|string|max:255',
            'experience' => 'nullable|array',
            'experience.*.title' => 'nullable|string|max:255',
            'experience.*.company' => 'nullable|string|max:255',
            'experience.*.period' => 'nullable|string|max:255',
            'experience.*.description' => 'nullable|array',
            'experience.*.description.*' => 'nullable|string|max:255',
            'education' => 'nullable|array',
            'education.*.degree' => 'nullable|string|max:255',
            'education.*.institution' => 'nullable|string|max:255',
            'education.*.period' => 'nullable|string|max:255',
            'education.*.description' => 'nullable|string|max:255',
            'hobbies' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Flatten the skills array
        $flattenedSkills = [];
        if (isset($validated['skills']) && is_array($validated['skills'])) {
            foreach ($validated['skills'] as $category => $skills) {
                if (is_array($skills)) {
                    foreach ($skills as $skill) {
                        if (isset($skill['name']) && $skill['name']) {
                            $flattenedSkills[] = $skill['name'];
                        }
                    }
                }
            }
            $validated['skills'] = $flattenedSkills;
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('about', 'public');
        }

        About::create($validated);

        return redirect()->route('about.index')->with('success', 'About page created successfully.');
    }

    /**
     * Show the form for editing the About entry.
     */
    public function edit($id)
    {
        $about = About::findOrFail($id);
        return view('about.edit', compact('about'));
    }

    /**
     * Update the specified About entry.
     */
    public function update(Request $request, $id)
    {
        $about = About::findOrFail($id);

        $validated = $request->validate([
            'bio' => 'nullable|string',
            'skills' => 'nullable|array',
            'skills.*.*.category' => 'nullable|string|in:Front-End Development,Back-End Development,Tools & Others',
            'skills.*.*.name' => 'nullable|string|max:255',
            'experience' => 'nullable|array',
            'experience.*.title' => 'nullable|string|max:255',
            'experience.*.company' => 'nullable|string|max:255',
            'experience.*.period' => 'nullable|string|max:255',
            'experience.*.description' => 'nullable|array',
            'experience.*.description.*' => 'nullable|string|max:255',
            'education' => 'nullable|array',
            'education.*.degree' => 'nullable|string|max:255',
            'education.*.institution' => 'nullable|string|max:255',
            'education.*.period' => 'nullable|string|max:255',
            'education.*.description' => 'nullable|string|max:255',
            'hobbies' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Flatten the skills array
        $flattenedSkills = [];
        if (isset($validated['skills']) && is_array($validated['skills'])) {
            foreach ($validated['skills'] as $category => $skills) {
                if (is_array($skills)) {
                    foreach ($skills as $skill) {
                        if (isset($skill['name']) && $skill['name']) {
                            $flattenedSkills[] = $skill['name'];
                        }
                    }
                }
            }
            $validated['skills'] = $flattenedSkills;
        }

        if ($request->hasFile('image')) {
            if ($about->image) {
                Storage::disk('public')->delete($about->image);
            }
            $validated['image'] = $request->file('image')->store('about', 'public');
        } else {
            // Preserve the existing image if no new one is uploaded
            $validated['image'] = $about->image;
        }

        $about->update($validated);

        return redirect()->route('about.index')->with('success', 'About page updated successfully.');
    }

    /**
     * Remove the specified About entry.
     */
    public function destroy($id)
    {
        $about = About::findOrFail($id);
        if ($about->image) {
            Storage::disk('public')->delete($about->image);
        }
        $about->delete();

        return redirect()->route('about.index')->with('success', 'About page deleted successfully.');
    }

    /**
     * API endpoint to get About data for frontend.
     */
    public function apiIndex()
    {
        $about = About::first();
        if ($about && $about->image) {
            $about->image = asset('storage/' . $about->image);
        }
        return response()->json($about);
    }
}