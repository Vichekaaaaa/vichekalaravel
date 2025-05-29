<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Logo;

class LogoController extends Controller
{
    public function index()
    {
        $logo = Logo::first();
        if (!$logo) {
            Log::warning('No logo record found in the database.');
        }
        return view('logo.index', compact('logo'));
    }

    public function edit()
    {
        $logo = Logo::first();
        if (!$logo) {
            Log::warning('No logo record found in the database for edit view.');
        }
        return view('logo.edit', compact('logo'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'logo.required' => 'Please upload a logo image.',
            'logo.image' => 'The uploaded file must be an image.',
            'logo.mimes' => 'The logo must be a JPEG, PNG, JPG, or GIF file.',
            'logo.max' => 'The logo file size must not exceed 2MB.',
        ]);

        try {
            if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
                $file = $request->file('logo');
                $imageData = base64_encode(file_get_contents($file->getRealPath()));
                $mimeType = $file->getMimeType();
                $base64Image = "data:{$mimeType};base64,{$imageData}";

                Logo::updateOrCreate(
                    ['id' => 1],
                    ['image_data' => $base64Image]
                );

                Log::info('Logo updated successfully with base64 data.');
                return redirect()->route('logo.index')->with('success', 'Logo updated successfully.');
            }

            Log::error('Failed to upload logo: No valid file provided.');
            return redirect()->back()->with('error', 'Failed to upload the logo. Please try again.');
        } catch (\Exception $e) {
            Log::error('Error updating logo: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the logo: ' . $e->getMessage());
        }
    }

    public function getLogo()
    {
        try {
            $logo = Logo::first();
            if (!$logo) {
                Log::warning('No logo record found in the database for API.');
                return response()->json([
                    'logo_url' => null,
                    'message' => 'No logo found in the database.',
                ], 404);
            }

            if ($logo->image_data) {
                return response()->json([
                    'logo_url' => $logo->image_data,
                ], 200);
            }

            Log::warning('No image data found for logo.');
            return response()->json([
                'logo_url' => null,
                'message' => 'No image data found for the logo.',
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error fetching logo via API: ' . $e->getMessage());
            return response()->json([
                'logo_url' => null,
                'message' => 'Error fetching logo: ' . $e->getMessage(),
            ], 500);
        }
    }
}