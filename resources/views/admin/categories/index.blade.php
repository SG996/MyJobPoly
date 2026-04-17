@extends('admin.layouts.app')

@section('title', 'Quản lý Danh mục')
@section('page-title', '🏷️ Quản lý Danh mục')
@section('page-subtitle', 'Quản lý các danh mục việc làm')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="breadcrumb-sep">/</span>
    <span>Danh mục</span>
</div>

<div style="display:grid;grid-template-columns:1fr 360px;gap:24px;align-items:start;">
    <!-- TABLE -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">Danh sách danh mục ({{ $categories->total() }})</div>
        </div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên danh mục</th>
                        <th>Số việc làm</th>
                        <th style="text-align:right;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td style="color:var(--text-secondary);font-size:12px;">{{ $category->id }}</td>
                        <td style="font-weight:500;">{{ $category->name }}</td>
                        <td>
                            <span class="badge badge-info">{{ $category->jobs_count }} việc làm</span>
                        </td>
                        <td>
                            <div style="display:flex;gap:6px;justify-content:flex-end;">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-outline btn-sm">✏️ Sửa</a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                      onsubmit="return confirm('Xóa danh mục này?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">🗑 Xóa</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align:center;padding:40px;color:var(--text-secondary);">Chưa có danh mục nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($categories->hasPages())
        <div class="card-body" style="border-top:1px solid var(--border);">
            <div class="pagination">
                @if($categories->onFirstPage())
                    <span class="page-link" style="opacity:.4;">‹</span>
                @else
                    <a href="{{ $categories->previousPageUrl() }}" class="page-link">‹</a>
                @endif
                @foreach($categories->getUrlRange(max(1,$categories->currentPage()-2), min($categories->lastPage(),$categories->currentPage()+2)) as $page => $url)
                    <a href="{{ $url }}" class="page-link {{ $page == $categories->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                @endforeach
                @if($categories->hasMorePages())
                    <a href="{{ $categories->nextPageUrl() }}" class="page-link">›</a>
                @else
                    <span class="page-link" style="opacity:.4;">›</span>
                @endif
            </div>
        </div>
        @endif
    </div>

    <!-- QUICK ADD FORM -->
    <div class="card" style="position:sticky;top:calc(var(--header-height) + 20px);">
        <div class="card-header">
            <div class="card-title">＋ Thêm danh mục</div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Tên danh mục <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                           placeholder="VD: Công nghệ thông tin" required autofocus>
                    @error('name')<div style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;">💾 Lưu danh mục</button>
            </form>
        </div>
    </div>
</div>

@endsection
