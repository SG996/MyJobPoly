@extends('admin.layouts.app')

@section('title', 'Sửa danh mục')
@section('page-title', '✏️ Sửa danh mục')
@section('page-subtitle', 'Cập nhật tên danh mục')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="breadcrumb-sep">/</span>
    <a href="{{ route('admin.categories.index') }}">Danh mục</a>
    <span class="breadcrumb-sep">/</span>
    <span>Sửa</span>
</div>

<div class="card" style="max-width:480px;">
    <div class="card-header">
        <div class="card-title">Danh mục #{{ $category->id }}</div>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline btn-sm">← Quay lại</a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">Tên danh mục <span style="color:var(--danger)">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                @error('name')<div style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div style="display:flex;gap:12px;">
                <button type="submit" class="btn btn-primary">💾 Cập nhật</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline">Hủy</a>
            </div>
        </form>
    </div>
</div>

@endsection
