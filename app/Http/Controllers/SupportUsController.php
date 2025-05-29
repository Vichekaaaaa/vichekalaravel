<?php

namespace App\Http\Controllers;

use App\Models\SupportUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupportUsController extends Controller
{
    public function apiIndex()
    {
        $supportUs = SupportUs::orderBy('order')->get();
        return response()->json($supportUs);
    }

    public function index()
    {
        $supportUs = SupportUs::orderBy('order')->get();
        return view('supportus.index', compact('supportUs'));
    }

    public function create()
    {
        $sections = SupportUs::whereNull('parent_section')->pluck('section')->toArray();
        return view('supportus.create', compact('sections'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'section' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = SupportUs::where('section', $value)
                        ->where('parent_section', $request->parent_section)
                        ->exists();
                    if ($exists) {
                        $fail('The section name must be unique within the selected parent section.');
                    }
                },
            ],
            'parent_section' => 'nullable|string|exists:support_us,section',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'buttons' => 'nullable|array',
            'buttons.*.text' => 'required_with:buttons|string|max:50',
            'buttons.*.url' => 'required_with:buttons|string',
            'icon' => 'nullable|string|max:255',
            'order' => 'required|integer|min:0',
            'style' => 'nullable|in:style1,style2', // Validate style
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        SupportUs::create([
            'section' => $request->section,
            'parent_section' => $request->parent_section ?: null,
            'title' => $request->title,
            'description' => $request->description,
            'buttons' => $request->buttons,
            'icon' => $request->icon,
            'order' => $request->order,
            'style' => $request->style, // Save the style
        ]);

        return redirect()->route('support-us.index')->with('success', 'Section created successfully.');
    }

    public function edit($id)
    {
        $section = SupportUs::findOrFail($id);
        $sections = SupportUs::whereNull('parent_section')->pluck('section')->toArray();
        if (!is_array($section->buttons)) {
            $section->buttons = [];
        }
        return view('supportus.edit', compact('section', 'sections'));
    }

    public function update(Request $request, $id)
    {
        $section = SupportUs::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'section' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($request, $id) {
                    $exists = SupportUs::where('section', $value)
                        ->where('parent_section', $request->parent_section)
                        ->where('id', '!=', $id)
                        ->exists();
                    if ($exists) {
                        $fail('The section name must be unique within the selected parent section.');
                    }
                },
            ],
            'parent_section' => 'nullable|string|exists:support_us,section',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'buttons' => 'nullable|array',
            'buttons.*.text' => 'required_with:buttons|string|max:50',
            'buttons.*.url' => 'required_with:buttons|string',
            'icon' => 'nullable|string|max:255',
            'order' => 'required|integer|min:0',
            'style' => 'nullable|in:style1,style2', // Validate style
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $section->update([
            'section' => $request->section,
            'parent_section' => $request->parent_section ?: null,
            'title' => $request->title,
            'description' => $request->description,
            'buttons' => $request->buttons,
            'icon' => $request->icon,
            'order' => $request->order,
            'style' => $request->style, // Save the style
        ]);

        return redirect()->route('support-us.edit', $section->id)
            ->with('success', 'Section updated successfully.');
    }

    public function destroy($id)
    {
        $section = SupportUs::findOrFail($id);
        $section->delete();
        return redirect()->route('support-us.index')->with('success', 'Section deleted successfully.');
    }
}