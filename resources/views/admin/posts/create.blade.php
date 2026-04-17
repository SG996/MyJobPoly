@extends('admin.layouts.app')

@section('title', 'Thêm bài viết')
@section('page-title', '＋ Thêm bài viết mới')
@section('page-subtitle', 'Soạn nội dung và xuất bản bài viết')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="breadcrumb-sep">/</span>
    <a href="{{ route('admin.posts.index') }}">Bài viết</a>
    <span class="breadcrumb-sep">/</span>
    <span>Thêm mới</span>
</div>

<form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" id="postForm">
    @csrf

    <div style="display:grid; grid-template-columns:1fr 320px; gap:20px; align-items:start;">

        {{-- CỘT TRÁI: Nội dung chính --}}
        <div>
            {{-- Tiêu đề --}}
            <div class="card" style="margin-bottom:20px;">
                <div class="card-body">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Tiêu đề bài viết <span style="color:var(--danger)">*</span></label>
                        <input type="text" name="title" id="titleInput" class="form-control"
                               style="font-size:18px; font-weight:600; padding:14px 16px;"
                               value="{{ old('title') }}"
                               placeholder="Nhập tiêu đề bài viết..." required
                               oninput="generateSlug(this.value)">
                        @error('title')<div style="color:var(--danger);font-size:12px;margin-top:5px;">{{ $message }}</div>@enderror
                        <div style="margin-top:8px; font-size:12px; color:var(--text-secondary);">
                            🔗 Slug: <span id="slugPreview" style="color:var(--primary); font-weight:500;">{{ old('slug') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Description / Excerpt --}}
            <div class="card" style="margin-bottom:20px;">
                <div class="card-header">
                    <div class="card-title">📋 Mô tả ngắn (hiển thị ở trang danh sách bài viết)</div>
                </div>
                <div class="card-body">
                    <div class="form-group" style="margin-bottom:0;">
                        <textarea name="excerpt" class="form-control" rows="3"
                                  placeholder="Viết 1-2 câu tóm tắt nội dung bài viết để thu hút người đọc..."
                                  maxlength="500">{{ old('excerpt') }}</textarea>
                        <div style="text-align:right; font-size:11px; color:var(--text-secondary); margin-top:4px;">
                            <span id="excerptCount">0</span>/500 ký tự
                        </div>
                        @error('excerpt')<div style="color:var(--danger);font-size:12px;">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- Nội dung --}}
            <div class="card" style="margin-bottom:20px;">
                <div class="card-header">
                    <div class="card-title">✍️ Nội dung bài viết <span style="color:var(--danger)">*</span></div>
                    <div style="display:flex;gap:8px;">
                        <button type="button" onclick="setFormat('bold')" class="btn btn-outline btn-sm" title="Bold"><b>B</b></button>
                        <button type="button" onclick="setFormat('h2')" class="btn btn-outline btn-sm" title="Heading">H2</button>
                        <button type="button" onclick="setFormat('bullet')" class="btn btn-outline btn-sm" title="List">• List</button>
                    </div>
                </div>
                <div class="card-body" style="padding:0;">
                    <textarea name="content" id="contentArea" class="form-control"
                              style="border:none; border-radius:0; min-height:420px; font-size:15px; line-height:1.8; padding:20px; resize:vertical;"
                              placeholder="Nhập nội dung bài viết tại đây... (hỗ trợ HTML cơ bản)" required>{{ old('content') }}</textarea>
                    @error('content')<div style="color:var(--danger);font-size:12px;padding:8px 16px;">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        {{-- CỘT PHẢI: Ảnh & Cài đặt --}}
        <div>
            {{-- Ảnh thumbnail --}}
            <div class="card" style="margin-bottom:20px;">
                <div class="card-header">
                    <div class="card-title">🖼️ Ảnh bìa bài viết</div>
                </div>
                <div class="card-body">
                    <div id="thumbnailPreview"
                         onclick="document.getElementById('thumbnailInput').click()"
                         style="width:100%; aspect-ratio:16/9; background:#f1f5f9; border:2px dashed #cbd5e1;
                                border-radius:10px; cursor:pointer; overflow:hidden; position:relative;
                                display:flex; align-items:center; justify-content:center;
                                transition:border-color .2s; margin-bottom:12px;">
                        <div id="thumbnailPlaceholder" style="text-align:center; color:var(--text-secondary); pointer-events:none;">
                            <div style="font-size:36px; margin-bottom:8px; opacity:.4;">🖼️</div>
                            <div style="font-size:13px; font-weight:600;">Click để chọn ảnh bìa</div>
                            <div style="font-size:11px; margin-top:4px;">JPG, PNG, WEBP • Tối đa 3MB</div>
                        </div>
                        <img id="thumbnailImg" src="" alt=""
                             style="display:none; width:100%; height:100%; object-fit:cover; position:absolute; inset:0;">
                        <div id="thumbnailOverlay"
                             style="display:none; position:absolute; inset:0; background:rgba(0,0,0,.4);
                                    align-items:center; justify-content:center; color:#fff; font-size:13px; font-weight:700;">
                            📷 Thay đổi ảnh
                        </div>
                    </div>

                    <input type="file" name="thumbnail" id="thumbnailInput" accept="image/*"
                           style="display:none;" onchange="previewThumbnail(this)">

                    <div style="display:flex; gap:8px;">
                        <button type="button" onclick="document.getElementById('thumbnailInput').click()"
                                class="btn btn-outline btn-sm" style="flex:1; justify-content:center;">
                            📁 Chọn ảnh
                        </button>
                        <button type="button" onclick="clearThumbnail()" id="btnClearThumb"
                                class="btn btn-sm" style="display:none; color:#dc3545; border:1px solid #fca5a5; background:#fff;">
                            🗑 Xóa
                        </button>
                    </div>

                    <div id="thumbFileName" style="display:none; margin-top:8px; font-size:11px; color:var(--success);
                                                    padding:5px 10px; background:#d1fae5; border-radius:6px;">
                        ✅ <span id="thumbFileNameText"></span>
                    </div>
                </div>
            </div>

            {{-- Cài đặt xuất bản --}}
            <div class="card" style="margin-bottom:20px;">
                <div class="card-header">
                    <div class="card-title">⚙️ Xuất bản</div>
                </div>
                <div class="card-body">
                    <div class="form-group" style="margin-bottom:16px;">
                        <label class="form-label">Trạng thái</label>
                        <select name="is_published" class="form-control">
                            <option value="1" {{ old('is_published', '1') == '1' ? 'selected' : '' }}>📢 Công khai</option>
                            <option value="0" {{ old('is_published') == '0' ? 'selected' : '' }}>🔒 Ẩn (nháp)</option>
                        </select>
                    </div>

                    <div style="display:flex; gap:10px; flex-direction:column;">
                        <button type="submit" class="btn btn-primary" style="justify-content:center; padding:12px;">
                            🚀 Đăng bài viết
                        </button>
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-outline"
                           style="justify-content:center;">← Quay lại</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>

@push('scripts')
<script>
function generateSlug(title) {
    const slug = title.toLowerCase()
        .replace(/[àáạảãâầấậẩẫăằắặẳẵ]/g, 'a')
        .replace(/[èéẹẻẽêềếệểễ]/g, 'e')
        .replace(/[ìíịỉĩ]/g, 'i')
        .replace(/[òóọỏõôồốộổỗơờớợởỡ]/g, 'o')
        .replace(/[ùúụủũưừứựửữ]/g, 'u')
        .replace(/[ỳýỵỷỹ]/g, 'y')
        .replace(/đ/g, 'd')
        .replace(/[^a-z0-9\s-]/g, '')
        .trim().replace(/\s+/g, '-').replace(/-+/g, '-');
    document.getElementById('slugPreview').textContent = slug;
}

function previewThumbnail(input) {
    const file = input.files[0];
    if (!file) return;
    if (file.size > 3 * 1024 * 1024) {
        alert('⚠️ File quá lớn! Tối đa 3MB.');
        input.value = ''; return;
    }
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById('thumbnailImg');
        const placeholder = document.getElementById('thumbnailPlaceholder');
        const overlay = document.getElementById('thumbnailOverlay');
        const btnClear = document.getElementById('btnClearThumb');
        img.src = e.target.result;
        img.style.display = 'block';
        placeholder.style.display = 'none';
        overlay.style.display = 'flex';
        btnClear.style.display = 'inline-flex';
        document.getElementById('thumbFileName').style.display = 'block';
        document.getElementById('thumbFileNameText').textContent = file.name;
    };
    reader.readAsDataURL(file);
}

function clearThumbnail() {
    document.getElementById('thumbnailImg').style.display = 'none';
    document.getElementById('thumbnailImg').src = '';
    document.getElementById('thumbnailPlaceholder').style.display = 'block';
    document.getElementById('thumbnailOverlay').style.display = 'none';
    document.getElementById('btnClearThumb').style.display = 'none';
    document.getElementById('thumbnailInput').value = '';
    document.getElementById('thumbFileName').style.display = 'none';
}

function setFormat(type) {
    const ta = document.getElementById('contentArea');
    const start = ta.selectionStart, end = ta.selectionEnd;
    const sel = ta.value.substring(start, end);
    let insert = '';
    if (type === 'bold')   insert = `<strong>${sel || 'văn bản'}</strong>`;
    if (type === 'h2')     insert = `\n<h2>${sel || 'Tiêu đề mục'}</h2>\n`;
    if (type === 'bullet') insert = `\n<ul>\n  <li>${sel || 'Điểm 1'}</li>\n  <li>Điểm 2</li>\n</ul>\n`;
    ta.setRangeText(insert, start, end, 'end');
    ta.focus();
}

// Đếm ký tự excerpt
const excerptEl = document.querySelector('[name="excerpt"]');
const countEl   = document.getElementById('excerptCount');
if (excerptEl && countEl) {
    countEl.textContent = excerptEl.value.length;
    excerptEl.addEventListener('input', () => countEl.textContent = excerptEl.value.length);
}

// Hover effect on thumbnail box
const box = document.getElementById('thumbnailPreview');
const overlay = document.getElementById('thumbnailOverlay');
box.addEventListener('mouseenter', () => { if (document.getElementById('thumbnailImg').style.display !== 'none') overlay.style.display = 'flex'; });
box.addEventListener('mouseleave', () => { overlay.style.display = 'none'; });
</script>
@endpush

@endsection
