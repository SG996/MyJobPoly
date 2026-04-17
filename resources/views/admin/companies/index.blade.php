@extends('admin.layouts.app')

@section('title', 'Quản lý Công ty')
@section('page-title', '🏢 Quản lý Công ty')
@section('page-subtitle', 'Danh sách các công ty tuyển dụng')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="breadcrumb-sep">/</span>
    <span>Công ty</span>
</div>

<div class="card" style="margin-bottom: 24px;">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <div class="card-title">Danh sách công ty ({{ $companies->total() }})</div>
        <a href="{{ route('admin.companies.create') }}" class="btn btn-primary">＋ Thêm công ty</a>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th style="width: 60px;">ID</th>
                    <th style="width: 80px;">Logo</th>
                    <th>Tên công ty</th>
                    <th>Liên hệ</th>
                    <th>Tin tuyển dụng</th>
                    <th style="text-align:right;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($companies as $company)
                <tr>
                    <td style="color:var(--text-secondary);font-size:12px;">{{ $company->id }}</td>
                    <td>
                        @if($company->logo)
                            <img src="{{ Storage::url($company->logo) }}" alt="Logo" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover; border: 1px solid var(--border);">
                        @else
                            <div style="width: 40px; height: 40px; border-radius: 8px; background: var(--body-bg); border: 1px dashed var(--border); display: flex; align-items: center; justify-content: center; font-size: 10px; color: var(--text-secondary);">No img</div>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight:600; color: var(--text-primary); margin-bottom: 4px;">{{ $company->name }}</div>
                        <div style="font-size: 12px; color: var(--text-secondary);">Mst: {{ $company->tax_code }}</div>
                    </td>
                    <td>
                        <div style="font-size: 13px; margin-bottom: 4px;">✉️ {{ $company->email }}</div>
                        <div style="font-size: 13px; color: var(--text-secondary);">📞 {{ $company->hotline }}</div>
                    </td>
                    <td>
                        <span class="badge badge-info">{{ $company->jobs_count ?? 0 }} việc làm</span>
                    </td>
                    <td>
                        <div style="display:flex;gap:6px;justify-content:flex-end;">
                            <a href="{{ route('admin.companies.edit', $company->id) }}" class="btn btn-outline btn-sm">✏️ Sửa</a>
                            <form action="{{ route('admin.companies.destroy', $company->id) }}" method="POST"
                                  onsubmit="return confirm('Xóa công ty này? Các việc làm của công ty sẽ bị ảnh hưởng.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">🗑 Xóa</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:40px;color:var(--text-secondary);">Chưa có công ty nào được tạo.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($companies->hasPages())
    <div class="card-body" style="border-top:1px solid var(--border);">
        <div class="pagination">
            @if($companies->onFirstPage())
                <span class="page-link" style="opacity:.4;">‹</span>
            @else
                <a href="{{ $companies->previousPageUrl() }}" class="page-link">‹</a>
            @endif
            @foreach($companies->getUrlRange(max(1,$companies->currentPage()-2), min($companies->lastPage(),$companies->currentPage()+2)) as $page => $url)
                <a href="{{ $url }}" class="page-link {{ $page == $companies->currentPage() ? 'active' : '' }}">{{ $page }}</a>
            @endforeach
            @if($companies->hasMorePages())
                <a href="{{ $companies->nextPageUrl() }}" class="page-link">›</a>
            @else
                <span class="page-link" style="opacity:.4;">›</span>
            @endif
        </div>
    </div>
    @endif
</div>

@endsection
