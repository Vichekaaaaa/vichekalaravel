<?php

namespace App\Http\Controllers;

use App\Models\ContactMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactMethodController extends Controller
{
    public function index(Request $request)
    {
        $contactMethods = ContactMethod::all();
        if ($request->expectsJson()) {
            return response()->json($contactMethods);
        }
        return view('contact-methods.index', compact('contactMethods'));
    }

    public function create()
    {
        return view('contact-methods.create');
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'url' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value && !preg_match('/^tel:|^https?:/', $value)) {
                        $fail('The ' . $attribute . ' must be a valid URL or tel link (e.g., https://example.com or tel:+1234567890).');
                    }
                },
            ],
            'type' => 'required|in:phone,social,email',
        ])->validate();

        ContactMethod::create($validatedData);
        return redirect()->route('contact-methods.index')->with('success', 'Contact method added successfully.');
    }

    public function edit($id)
    {
        $contactMethod = ContactMethod::findOrFail($id);
        return view('contact-methods.edit', compact('contactMethod'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'url' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value && !preg_match('/^tel:|^https?:/', $value)) {
                        $fail('The ' . $attribute . ' must be a valid URL or tel link (e.g., https://example.com or tel:+1234567890).');
                    }
                },
            ],
            'type' => 'required|in:phone,social,email',
        ])->validate();

        $contactMethod = ContactMethod::findOrFail($id);
        $contactMethod->update($validatedData);
        return redirect()->route('contact-methods.index')->with('success', 'Contact method updated successfully.');
    }

    public function destroy($id)
    {
        $contactMethod = ContactMethod::findOrFail($id);
        $contactMethod->delete();
        return redirect()->route('contact-methods.index')->with('success', 'Contact method deleted successfully.');
    }
}