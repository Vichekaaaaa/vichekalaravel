<?php

namespace App\Http\Controllers;

use App\Models\ContactMethod;
use App\Models\Project;
use App\Models\Category;
use App\Models\Tutorial; // Assuming a Tutorial model

class DashboardController extends Controller
{
    public function index()
    {
        $contactMethodCount = ContactMethod::count();
        $projectCount = Project::count();
        $categoryCount = Category::count();
        $tutorialCount = Tutorial::count(); // Fetch tutorial count
        return view('dashboard', compact('contactMethodCount', 'projectCount', 'categoryCount', 'tutorialCount'));
    }
}