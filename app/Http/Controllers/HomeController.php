<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Category;
use App\Models\Company;
use App\Models\Post;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        $locations = [
            'Ngẫu Nhiên' => null,
            'Hà Nội' => 'Hà Nội',
            'Thành phố Hồ Chí Minh' => 'TP. Hồ Chí Minh',
            'Miền Bắc' => 'Miền Bắc',
            'Miền Nam' => 'Miền Nam'
        ];

        $jobsQuery = Job::with('company')->where('is_active', true)->latest();

        $location = $request->query('location');
        if ($location && array_search($location, $locations) !== false) {
            $jobsQuery->where('location', $location);
        }

        $jobs = $jobsQuery->paginate(12)->withQueryString();

        // Công ty nổi bật (có nhiều job active nhất)
        $topCompanies = Company::withCount(['jobs' => function ($q) {
                            $q->where('is_active', true);
                        }])
                        ->having('jobs_count', '>', 0)
                        ->orderByDesc('jobs_count')
                        ->take(8)
                        ->get();

        // Bài viết mới nhất
        $latestPosts = Post::where('is_published', true)->latest()->take(3)->get();

        // Thống kê
        $stats = [
            'jobs'      => Job::where('is_active', true)->count(),
            'companies' => Company::count(),
            'users'     => \App\Models\User::where('role', 0)->count(),
        ];

        return view('home', compact('categories', 'jobs', 'locations', 'topCompanies', 'latestPosts', 'stats'));
    }

    public function jobs(Request $request)
    {
        $categories = Category::all();
        $locations = [
            'Ngẫu Nhiên' => null,
            'Hà Nội' => 'Hà Nội',
            'Thành phố Hồ Chí Minh' => 'TP. Hồ Chí Minh',
            'Miền Bắc' => 'Miền Bắc',
            'Miền Nam' => 'Miền Nam'
        ];

        $jobsQuery = Job::with('company')->where('is_active', true)->latest();

        if ($request->filled('keyword')) {
            $jobsQuery->where('title', 'like', '%' . $request->keyword . '%');
        }

        if ($request->filled('location') && $request->location != 'all') {
            $jobsQuery->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('category_id') && $request->category_id != 'all') {
            $jobsQuery->where('category_id', $request->category_id);
        }

        $jobs = $jobsQuery->paginate(12)->withQueryString();

        return view('jobs', compact('categories', 'jobs', 'locations'));
    }

    public function show($id)
    {
        $job = Job::with(['company', 'category'])->findOrFail($id);

        $similarJobs = Job::where('category_id', $job->category_id)
                          ->where('id', '!=', $id)
                          ->where('is_active', true)
                          ->latest()
                          ->take(5)
                          ->get();

        return view('show', compact('job', 'similarJobs'));
    }

    public function company($id)
    {
        $company = Company::with('employers')->findOrFail($id);

        $jobs = Job::where('company_id', $id)
                   ->where('is_active', true)
                   ->with('category')
                   ->latest()
                   ->paginate(6, ['*'], 'jobs_page');

        $employerIds = $company->employers->pluck('id');
        $miniTasks = \App\Models\MiniTask::whereIn('employer_id', $employerIds)
                   ->where('is_active', true)
                   ->latest()
                   ->paginate(6, ['*'], 'minitasks_page');

        $totalJobs = Job::where('company_id', $id)->where('is_active', true)->count();
        $totalMiniTasks = \App\Models\MiniTask::whereIn('employer_id', $employerIds)->where('is_active', true)->count();

        return view('company', compact('company', 'jobs', 'totalJobs', 'miniTasks', 'totalMiniTasks'));
    }

    // ===== BAI VIET =====

    public function posts()
    {
        $posts       = Post::where('is_published', true)->latest()->paginate(9);
        $recentPosts = Post::where('is_published', true)->latest()->take(5)->get();
        $hotJobs     = Job::with('company')->where('is_active', true)->latest()->take(3)->get();

        return view('post', compact('posts', 'recentPosts', 'hotJobs'));
    }

    public function postDetail($slug)
    {
        $post = Post::where('slug', $slug)->where('is_published', true)->firstOrFail();

        $relatedPosts = Post::where('is_published', true)
                           ->where('id', '!=', $post->id)
                           ->latest()
                           ->take(4)
                           ->get();

        $hotJobs = Job::with('company')->where('is_active', true)->latest()->take(3)->get();

        return view('post-detail', compact('post', 'relatedPosts', 'hotJobs'));
    }
    public function userProfile($id)
    {
        $user = \App\Models\User::findOrFail($id);
        
        // Không cho phép xem profile của admin/employer trên trang public user profile
        if ($user->role != 0) {
            abort(404);
        }

        return view('user.show', compact('user'));
    }
}