<?php
namespace App\Http\Controllers;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Experience;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $profile = Profile::first();
        $projects = Project::where('status', 'published')->latest()->get();
        $skills = Skill::orderBy('name')->get();
        $experiences = Experience::latest('start_date')->get();

        return view('home', compact('profile', 'projects', 'skills', 'experiences'));
    }
}