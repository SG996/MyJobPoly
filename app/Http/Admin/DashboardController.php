<?php

namespace App\Http\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\User;
use App\Models\Category;
use App\Models\Company;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_jobs'       => Job::count(),
            'active_jobs'      => Job::where('is_active', true)->count(),
            'total_users'      => User::count(),
            'total_categories' => Category::count(),
            'total_companies'  => Company::count(),
            'recent_jobs'      => Job::with('company', 'category')->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
