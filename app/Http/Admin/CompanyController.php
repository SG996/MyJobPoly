<?php

namespace App\Http\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function index()
    {
        // Chỉ lấy công ty có ít nhất 1 nhà tuyển dụng đã được duyệt
        $companies = Company::withCount('jobs')
            ->whereHas('employers', function ($q) {
                $q->where('is_approved', true)->where('role', 2);
            })
            ->with(['employers' => function ($q) {
                $q->where('role', 2)->select('id', 'company_id', 'is_approved', 'email');
            }])
            ->latest()
            ->paginate(12);
        return view('admin.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('admin.companies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'address'     => 'required|string|max:255',
            'tax_code'    => 'required|string|max:50|unique:companies,tax_code',
            'email'       => 'required|email|unique:companies,email',
            'hotline'     => 'required|string|max:20',
            'description' => 'nullable|string',
            'logo'        => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('companies', 'public');
        }

        Company::create($data);

        return redirect()->route('admin.companies.index')->with('success', 'Thêm công ty thành công!');
    }

    public function show($id)
    {
        $company = Company::withCount('jobs')->with('jobs')->findOrFail($id);
        return view('admin.companies.show', compact('company'));
    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('admin.companies.edit', compact('company'));
    }

    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'address'     => 'required|string|max:255',
            'tax_code'    => 'required|string|max:50|unique:companies,tax_code,' . $id,
            'email'       => 'required|email|unique:companies,email,' . $id,
            'hotline'     => 'required|string|max:20',
            'description' => 'nullable|string',
            'logo'        => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->except(['logo', '_method', '_token']);

        if ($request->hasFile('logo')) {
            // Xóa logo cũ
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }
            $data['logo'] = $request->file('logo')->store('companies', 'public');
        }

        $company->update($data);

        return redirect()->route('admin.companies.index')->with('success', 'Cập nhật công ty thành công!');
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);

        if ($company->logo) {
            Storage::disk('public')->delete($company->logo);
        }

        $company->delete();

        return redirect()->route('admin.companies.index')->with('success', 'Xóa công ty thành công!');
    }
}
