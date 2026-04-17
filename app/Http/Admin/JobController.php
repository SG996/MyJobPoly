<?php

namespace App\Http\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Category;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::with('company', 'category')->latest()->paginate(15);
        return view('admin.jobs.index', compact('jobs'));
    }

    public function create()
    {
        $categories = Category::all();
        $companies  = Company::all();
        return view('admin.jobs.create', compact('categories', 'companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'company_id'   => 'required|exists:companies,id',
            'category_id'  => 'required|exists:categories,id',
            'location'     => 'required|string|max:255',
            'salary'       => 'nullable|string|max:255',
            'experience'   => 'nullable|string|max:255',
            'deadline'     => 'nullable|date',
            'description'  => 'required|string',
            'requirements' => 'nullable|string',
            'benefits'     => 'nullable|string',
        ]);

        // Tự động tạo slug từ title
        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $count = 1;
        while (Job::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        Job::create([
            'title'        => $request->title,
            'slug'         => $slug,
            'company_id'   => $request->company_id,
            'category_id'  => $request->category_id,
            'location'     => $request->location,
            'salary'       => $request->salary ?? 'Thỏa thuận',
            'experience'   => $request->experience ?? 'Không yêu cầu',
            'deadline'     => $request->deadline ?? now()->addMonths(1)->toDateString(),
            'description'  => $request->description,
            'requirements' => $request->requirements ?? '',
            'benefits'     => $request->benefits ?? '',
            'employer_id'  => auth()->id() ?? 1,
            'is_active'    => $request->is_active ?? 1,
        ]);

        return redirect()->route('admin.jobs.index')->with('success', 'Tạo việc làm thành công!');
    }

    public function edit($id)
    {
        $job        = Job::findOrFail($id);
        $categories = Category::all();
        $companies  = Company::all();
        return view('admin.jobs.edit', compact('job', 'categories', 'companies'));
    }

    public function update(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        $request->validate([
            'title'        => 'required|string|max:255',
            'company_id'   => 'required|exists:companies,id',
            'category_id'  => 'required|exists:categories,id',
            'location'     => 'required|string|max:255',
            'salary'       => 'nullable|string|max:255',
            'experience'   => 'nullable|string|max:255',
            'deadline'     => 'nullable|date',
            'description'  => 'required|string',
            'requirements' => 'nullable|string',
            'benefits'     => 'nullable|string',
        ]);

        $job->update([
            'title'        => $request->title,
            'company_id'   => $request->company_id,
            'category_id'  => $request->category_id,
            'location'     => $request->location,
            'salary'       => $request->salary ?? $job->salary,
            'experience'   => $request->experience ?? $job->experience,
            'deadline'     => $request->deadline ?? $job->deadline,
            'description'  => $request->description,
            'requirements' => $request->requirements ?? $job->requirements,
            'benefits'     => $request->benefits ?? $job->benefits,
            'is_active'    => $request->is_active ?? $job->is_active,
        ]);

        return redirect()->route('admin.jobs.index')->with('success', 'Cập nhật việc làm thành công!');
    }

    public function destroy($id)
    {
        Job::findOrFail($id)->delete();
        return redirect()->route('admin.jobs.index')->with('success', 'Xóa việc làm thành công!');
    }

    public function toggleActive($id)
    {
        $job = Job::findOrFail($id);
        $job->update(['is_active' => !$job->is_active]);
        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
    }
}
