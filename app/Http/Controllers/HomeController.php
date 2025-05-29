<?php

namespace App\Http\Controllers;

use App\Models\Home;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $homeData = Home::first();

        if (!$homeData) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'No home data found.'], 404);
            }
            return redirect()->route('home.edit')->with('error', 'No home data found. Please add data.');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'name' => $homeData->name,
                'roles' => $homeData->roles,
                'bio' => $homeData->bio,
                'cta_text' => $homeData->cta_text,
                'cta_bio' => $homeData->cta_bio, // Include cta_bio in API response
                'stats' => $homeData->stats,
                'social_links' => $homeData->social_links,
                'buttons' => $homeData->buttons,
                'cta_buttons' => $homeData->cta_buttons,
            ]);
        }

        return view('home.index', compact('homeData'));
    }

    public function edit()
    {
        $homeData = Home::first();

        if (!$homeData) {
            $homeData = Home::create([
                'name' => 'NY Vicheka',
                'roles' => ['UI/UX Designer', 'Web Developer', 'Freelancer'],
                'stats' => [
                    ['number' => '50+', 'label' => 'Projects'],
                    ['number' => '100%', 'label' => 'Satisfaction'],
                    ['number' => '5+', 'label' => 'Years Exp'],
                    ['number' => '∞', 'label' => 'Creativity'],
                ],
                'social_links' => [
                    [
                        'platform' => 'Facebook',
                        'url' => '#',
                        'color' => 'bg-blue-600',
                        'icon' => 'M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z',
                    ],
                    [
                        'platform' => 'LinkedIn',
                        'url' => '#',
                        'color' => 'bg-blue-800',
                        'icon' => 'M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2 16h-2v-6h2v6zm-1-6.891c-.607 0-1.1-.496-1.1-1.109 0-.612.492-1.109 1.1-1.109s1.1.497 1.1 1.109c0 .613-.493 1.109-1.1 1.109zm8 6.891h-1.998v-2.861c0-1.881-2.002-1.722-2.002 0v2.861h-2v-6h2v1.093c.872-1.616 4-1.736 4 1.548v3.359z',
                    ],
                    [
                        'platform' => 'GitHub',
                        'url' => '#',
                        'color' => 'bg-gray-800',
                        'icon' => 'M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z',
                    ],
                ],
                'bio' => 'Crafting beautiful and functional web experiences with passion, precision, and a touch of creativity.',
                'cta_text' => 'Ready to Bring Your Vision to Life?',
                'cta_bio' => "Let's collaborate to create something extraordinary. Whether you need a stunning website, a brand refresh, or custom digital solutions, I'm here to help.",
                'buttons' => [
                    ['text' => 'Edit Home Data', 'link' => '/admin/home/edit'],
                    ['text' => 'Contact Me', 'link' => '/contact'],
                ],
                'cta_buttons' => [
                    ['text' => 'Explore Projects', 'link' => '/projects'],
                    ['text' => 'Get In Touch', 'link' => '/contact'],
                ],
            ]);
        }

        return view('home.edit', compact('homeData'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'roles' => 'required|string',
            'stats' => 'required|array',
            'social_links' => 'required|array',
            'bio' => 'nullable|string',
            'cta_text' => 'nullable|string',
            'cta_bio' => 'nullable|string', // Validate cta_bio separately
            'buttons' => 'required|array',
            'buttons.*.text' => 'required|string|max:255',
            'buttons.*.link' => 'required|string|max:255',
            'cta_buttons' => 'required|array',
            'cta_buttons.*.text' => 'required|string|max:255',
            'cta_buttons.*.link' => 'required|string|max:255',
        ]);

        try {
            $roles = array_map('trim', explode(',', $request->input('roles')));

            $homeData = Home::first();
            if ($homeData) {
                $homeData->update([
                    'name' => $request->name,
                    'roles' => $roles,
                    'stats' => $request->stats,
                    'social_links' => $request->social_links,
                    'bio' => $request->bio,
                    'cta_text' => $request->cta_text, // Save as separate field
                    'cta_bio' => $request->cta_bio,  // Save as separate field
                    'buttons' => $request->buttons,
                    'cta_buttons' => $request->cta_buttons,
                ]);
            } else {
                Home::create([
                    'name' => $request->name,
                    'roles' => $roles,
                    'stats' => $request->stats,
                    'social_links' => $request->social_links,
                    'bio' => $request->bio,
                    'cta_text' => $request->cta_text,
                    'cta_bio' => $request->cta_bio,
                    'buttons' => $request->buttons,
                    'cta_buttons' => $request->cta_buttons,
                ]);
            }

            return redirect()->route('home.index')->with('success', 'Home data updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('home.edit')->with('error', 'Error updating home data: ' . $e->getMessage());
        }
    }

    public function editButton($index)
    {
        $homeData = Home::first();
        if (!$homeData || !isset($homeData->buttons[$index])) {
            return redirect()->route('home.index')->with('error', 'Button not found.');
        }

        $button = $homeData->buttons[$index];
        return view('home.edit-button', compact('homeData', 'index', 'button'));
    }

    public function updateButton(Request $request, $index)
    {
        $request->validate([
            'text' => 'required|string|max:255',
            'link' => 'required|string|max:255',
        ]);

        $homeData = Home::first();
        if ($homeData && isset($homeData->buttons[$index])) {
            $buttons = $homeData->buttons;
            $buttons[$index] = [
                'text' => $request->text,
                'link' => $request->link,
            ];
            $homeData->update(['buttons' => $buttons]);
            return redirect()->route('home.index')->with('success', 'Button updated successfully.');
        }

        return redirect()->route('home.index')->with('error', 'Button not found.');
    }

    public function editCtaButton($index)
    {
        $homeData = Home::first();
        if (!$homeData || !isset($homeData->cta_buttons[$index])) {
            return redirect()->route('home.index')->with('error', 'CTA Button not found.');
        }

        $button = $homeData->cta_buttons[$index];
        return view('home.edit-cta-button', compact('homeData', 'index', 'button'));
    }

    public function updateCtaButton(Request $request, $index)
    {
        $request->validate([
            'text' => 'required|string|max:255',
            'link' => 'required|string|max:255',
        ]);

        $homeData = Home::first();
        if ($homeData && isset($homeData->cta_buttons[$index])) {
            $ctaButtons = $homeData->cta_buttons;
            $ctaButtons[$index] = [
                'text' => $request->text,
                'link' => $request->link,
            ];
            $homeData->update(['cta_buttons' => $ctaButtons]);
            return redirect()->route('home.index')->with('success', 'CTA Button updated successfully.');
        }

        return redirect()->route('home.index')->with('error', 'CTA Button not found.');
    }

    public function updateCtaButtonApi(Request $request, $index)
    {
        $request->validate([
            'text' => 'required|string|max:255',
            'link' => 'required|string|max:255',
        ]);

        $homeData = Home::first();
        if ($homeData && isset($homeData->cta_buttons[$index])) {
            $ctaButtons = $homeData->cta_buttons;
            $ctaButtons[$index] = [
                'text' => $request->text,
                'link' => $request->link,
            ];
            $homeData->update(['cta_buttons' => $ctaButtons]);
            return response()->json(['success' => true, 'message' => 'CTA Button updated successfully']);
        }

        return response()->json(['success' => false, 'message' => 'CTA Button not found'], 404);
    }
}