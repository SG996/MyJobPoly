<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Job;
use App\Models\Application;
use App\Models\Category;

class EmployerController extends Controller
{
    // ===========================================
    // DASHBOARD — Tổng quan nhà tuyển dụng
    // ===========================================
    public function dashboard()
    {
        $user    = Auth::user();
        $company = $user->company;

        // Thống kê
        $totalJobs        = Job::where('employer_id', $user->id)->count();
        $activeJobs       = Job::where('employer_id', $user->id)->where('is_active', true)->count();
        $totalApplications = Application::whereHas('job', function ($q) use ($user) {
            $q->where('employer_id', $user->id);
        })->count();
        $pendingApplications = Application::whereHas('job', function ($q) use ($user) {
            $q->where('employer_id', $user->id);
        })->where('status', 'pending')->count();

        // Bài đăng gần nhất
        $recentJobs = Job::where('employer_id', $user->id)
                         ->with('applications')
                         ->latest()
                         ->take(5)
                         ->get();

        // Đơn ứng tuyển gần nhất
        $recentApplications = Application::whereHas('job', function ($q) use ($user) {
            $q->where('employer_id', $user->id);
        })
        ->with(['user', 'job'])
        ->latest()
        ->take(5)
        ->get();

        return view('employer.dashboard', compact(
            'company',
            'totalJobs',
            'activeJobs',
            'totalApplications',
            'pendingApplications',
            'recentJobs',
            'recentApplications'
        ));
    }

    // ===========================================
    // ĐĂNG BÀI TUYỂN DỤNG
    // ===========================================
    public function createJob()
    {
        $categories = Category::orderBy('name')->get();
        return view('employer.create-job', compact('categories'));
    }

    public function storeJob(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'salary'       => 'required|string|max:100',
            'location'     => 'required|string|max:255',
            'experience'   => 'required|string|max:100',
            'deadline'     => 'required|date|after:today',
            'category_id'  => 'required|exists:categories,id',
            'description'  => 'required|string',
            'requirements' => 'required|string',
            'benefits'     => 'nullable|string',
            'degree'       => 'nullable|string|max:100',
            'level'        => 'nullable|string|max:100',
            'quantity'     => 'nullable|integer|min:1',
        ], [
            'title.required'       => 'Vui lòng nhập tiêu đề công việc.',
            'deadline.after'       => 'Hạn nộp hồ sơ phải là ngày trong tương lai.',
            'category_id.required' => 'Vui lòng chọn danh mục.',
            'category_id.exists'   => 'Danh mục không hợp lệ.',
        ]);

        $user    = Auth::user();
        $company = $user->company;

        Job::create([
            'title'        => $request->title,
            'slug'         => Str::slug($request->title) . '-' . time(),
            'company_id'   => $company->id,
            'employer_id'  => $user->id,
            'salary'       => $request->salary,
            'location'     => $request->location,
            'experience'   => $request->experience,
            'deadline'     => $request->deadline,
            'category_id'  => $request->category_id,
            'description'  => $request->description,
            'requirements' => $request->requirements,
            'benefits'     => $request->benefits ?? '',
            'degree'       => $request->degree,
            'level'        => $request->level,
            'quantity'     => $request->quantity ?? 1,
            'is_active'    => true,
        ]);

        return redirect()->route('employer.dashboard')
                         ->with('success', 'Đăng bài tuyển dụng thành công!');
    }

    // ===========================================
    // QUẢN LÝ BÀI ĐĂNG
    // ===========================================
    public function myJobs()
    {
        $user = Auth::user();
        $jobs = Job::where('employer_id', $user->id)
                   ->withCount('applications')
                   ->latest()
                   ->paginate(10);

        return view('employer.my-jobs', compact('jobs'));
    }

    public function toggleJob($id)
    {
        $job = Job::where('id', $id)->where('employer_id', Auth::id())->firstOrFail();
        $job->update(['is_active' => !$job->is_active]);
        return back()->with('success', $job->is_active ? 'Bài đăng đã được bật.' : 'Bài đăng đã được ẩn.');
    }

    public function editJob($id)
    {
        $job        = Job::where('id', $id)->where('employer_id', Auth::id())->firstOrFail();
        $categories = Category::orderBy('name')->get();
        return view('employer.edit-job', compact('job', 'categories'));
    }

    public function updateJob(Request $request, $id)
    {
        $job = Job::where('id', $id)->where('employer_id', Auth::id())->firstOrFail();

        $request->validate([
            'title'        => 'required|string|max:255',
            'salary'       => 'required|string|max:100',
            'location'     => 'required|string|max:255',
            'experience'   => 'required|string|max:100',
            'deadline'     => 'required|date',
            'category_id'  => 'required|exists:categories,id',
            'description'  => 'required|string',
            'requirements' => 'required|string',
            'benefits'     => 'nullable|string',
            'degree'       => 'nullable|string|max:100',
            'level'        => 'nullable|string|max:100',
            'quantity'     => 'nullable|integer|min:1',
        ], [
            'category_id.required' => 'Vui lòng chọn danh mục.',
            'category_id.exists'   => 'Danh mục không hợp lệ.',
        ]);

        $job->update([
            'title'        => $request->title,
            'salary'       => $request->salary,
            'location'     => $request->location,
            'experience'   => $request->experience,
            'deadline'     => $request->deadline,
            'category_id'  => $request->category_id,
            'description'  => $request->description,
            'requirements' => $request->requirements,
            'benefits'     => $request->benefits ?? '',
            'degree'       => $request->degree,
            'level'        => $request->level,
            'quantity'     => $request->quantity ?? 1,
        ]);

        return redirect()->route('employer.jobs.index')
                         ->with('success', 'Cập nhật tin tuyển dụng thành công!');
    }

    // ===========================================
    // XEM VÀ DUYỆT CV ỨNG TUYỂN
    // ===========================================
    public function applications(Request $request)
    {
        $user   = Auth::user();
        $jobId  = $request->get('job_id');

        // Danh sách tất cả job của nhà tuyển dụng (để filter)
        $myJobs = Job::where('employer_id', $user->id)->orderBy('created_at', 'desc')->get();

        // Query đơn ứng tuyển
        $query = Application::whereHas('job', function ($q) use ($user) {
            $q->where('employer_id', $user->id);
        })->with(['user', 'job']);

        if ($jobId) {
            $query->where('job_id', $jobId);
        }

        $applications = $query->latest()->paginate(15);

        return view('employer.applications', compact('applications', 'myJobs', 'jobId'));
    }

    public function updateApplicationStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        // Chắc chắn đây là đơn thuộc job của nhà tuyển dụng này
        $application = Application::whereHas('job', function ($q) {
            $q->where('employer_id', Auth::id());
        })->findOrFail($id);

        $application->update(['status' => $request->status]);

        $messages = [
            'approved' => '✅ Đã duyệt đơn ứng tuyển.',
            'rejected' => '❌ Đã từ chối đơn ứng tuyển.',
            'pending'  => '🔄 Đã đặt lại trạng thái chờ duyệt.',
        ];

        return back()->with('success', $messages[$request->status]);
    }

    // ===========================================
    // CÀI ĐẶT PROFILE CÔNG TY
    // ===========================================
    public function profile()
    {
        $company = Auth::user()->company;
        return view('employer.profile', compact('company'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'address'      => 'nullable|string|max:500',
            'hotline'      => 'nullable|string|max:20',
            'description'  => 'nullable|string',
            'logo'         => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
        ], [
            'logo.image'  => 'File phải là ảnh.',
            'logo.mimes'  => 'Chỉ chấp nhận định dạng JPG, PNG, WEBP hoặc GIF.',
            'logo.max'    => 'Ảnh tối đa 2MB.',
        ]);

        $company = Auth::user()->company;

        $data = [
            'name'        => $request->company_name,
            'address'     => $request->address ?? '',
            'hotline'     => $request->hotline ?? '',
            'description' => $request->description,
        ];

        // Xử lý xóa logo
        if ($request->input('remove_logo') == '1' && $company->logo) {
            \Storage::disk('public')->delete($company->logo);
            $data['logo'] = null;
        }

        // Xử lý upload logo mới
        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            // Xóa logo cũ nếu có
            if ($company->logo) {
                \Storage::disk('public')->delete($company->logo);
            }
            $path = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $path;
        }

        $company->update($data);

        return back()->with('success', 'Cập nhật thông tin công ty thành công!');
    }
}
