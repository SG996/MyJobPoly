@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa bài viết')
@section('page-title', '✏️ Chỉnh sửa bài viết')
@section('page-subtitle', 'Cập nhật nội dung và thông tin bài viết')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="breadcrumb-sep">/</span>
    <a href="{{ route('admin.posts.index') }}">Bài viết</a>
    <span class="breadcrumb-sep">/</span>
    <span>Chỉnh sửa</span>
</div>

<form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <input type="hidden" name="remove_thumbnail" id="removeThumbnail" value="0">

    <div style="display:grid; grid-template-columns:1fr 320px; gap:20px; align-items:start;">

        {{-- CỘT TRÁI --}}
        <div>
            {{-- Tiêu đề --}}
            <div class="card" style="margin-bottom:20px;">
                <div class="card-body">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Tiêu đề bài viết <span style="color:var(--danger)">*</span></label>
                        <input type="text" name="title" class="form-control"
                               style="font-size:18px; font-weight:600; padding:14px 16px;"
                               value="{{ old('title', $post->title) }}" required>
                        @error('title')<div style="color:var(--danger);font-size:12px;margin-top:5px;">{{ $message }}</div>@enderror
                        <div style="margin-top:8px; font-size:12px; color:var(--text-secondary);">
                            🔗 Slug: <span style="color:var(--primary); font-weight:500;">{{ $post->slug }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Excerpt --}}
            <div class="card" style="margin-bottom:20px;">
                <div class="card-header">
                    <div class="card-title">📋 Mô tả ngắn</div>
                </div>
                <div class="card-body">
                    <div class="form-group" style="margin-bottom:0;">
                        <textarea name="excerpt" class="form-control" rows="3"
                                  placeholder="Viết 1-2 câu tóm tắt nội dung bài viết..."
                                  maxlength="500">{{ old('excerpt', $post->excerpt) }}</textarea>
                        <div style="text-align:right; font-size:11px; color:var(--text-secondary); margin-top:4px;">
                            <span id="excerptCount">{{ strlen($post->excerpt ?? '') }}</span>/500 ký tự
                        </div>
                    </div>
                </div>
            </div>

            {{-- Nội dung --}}
            <div class="card" style="margin-bottom:20px;">
                <div class="card-header">
                    <div class="card-title">✍️ Nội dung bài viết <span style="color:var(--danger)">*</span></div>
                    <div style="display:flex;gap:8px;">
                        <button type="button" onclick="setFormat('bold')" class="btn btn-outline btn-sm"><b>B</b></button>
                        <button type="button" onclick="setFormat('h2')" class="btn btn-outline btn-sm">H2</button>
                        <button type="button" onclick="setFormat('bullet')" class="btn btn-outline btn-sm">• List</button>
                    </div>
                </div>
                <div class="card-body" style="padding:0;">
                    <textarea name="content" id="contentArea" class="form-control"
                              style="border:none; border-radius:0; min-height:420px; font-size:15px; line-height:1.8; padding:20px; resize:vertical;"
                              required>{{ old('content', $post->content) }}</textarea>
                    @error('content')<div style="color:var(--danger);font-size:12px;padding:8px 16px;">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        {{-- CỘT PHẢI --}}
        <div>
            {{-- Thumbnail --}}
            <div class="card" style="margin-bottom:20px;">
                <div class="card-header">
                    <div class="card-title">🖼️ Ảnh bìa</div>
                </div>
                <div class="card-body">
                    <div id="thumbnailPreview"
                         onclick="document.getElementById('thumbnailInput').click()"
                         style="width:100%; aspect-ratio:16/9; border:2px dashed #cbd5e1; border-radius:10px;
                                cursor:pointer; overflow:hidden; position:relative; display:flex;
                                align-items:center; justify-content:center; margin-bottom:12px; background:#f1f5f9;">
                        @if($post->thumbnail)
                            <img id="thumbnailImg" src="{{ $post->thumbnail_url }}" alt=""
                                 style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0;">
                            <div id="thumbnailOverlay"
                                 style="display:none; position:absolute; inset:0; background:rgba(0,0,0,.4);
                                        align-items:center; justify-content:center; color:#fff; font-size:13px; font-weight:700;">
                                📷 Thay đổi ảnh
                            </div>
                        @else
                            <div id="thumbnailPlaceholder" style="text-align:center; color:var(--text-secondary); pointer-events:none;">
                                <div style="font-size:36px; opacity:.4;">🖼️</div>
                                <div style="font-size:13px; font-weight:600; margin-top:8px;">Click để chọn ảnh</div>
                            </div>
                            <img id="thumbnailImg" src="" alt="" style="display:none; width:100%;height:100%;object-fit:cover;position:absolute;inset:0;">
                            <div id="thumbnailOverlay"
                                 style="display:none; position:absolute; inset:0; background:rgba(0,0,0,.4);
                                        align-items:center; justify-content:center; color:#fff; font-size:13px; font-weight:700;">
                                📷 Thay đổi ảnh
                            </div>
                        @endif
                    </div>

                    <input type="file" name="thumbnail" id="thumbnailInput" accept="image/*"
                           style="display:none;" onchange="previewThumbnail(this)">

                    <div style="display:flex; gap:8px;">
                        <button type="button" onclick="document.getElementById('thumbnailInput').click()"
                                class="btn btn-outline btn-sm" style="flex:1; justify-content:center;">
                            📁 Chọn ảnh
                        </button>
                        @if($post->thumbnail)
                        <button type="button" onclick="removeThumb()"
                                class="btn btn-sm" style="color:#dc3545; border:1px solid #fca5a5; background:#fff;">
                            🗑 Xóa
                        </button>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Cài đặt --}}
            <div class="card" style="margin-bottom:20px;">
                <div class="card-header">
                    <div class="card-title">⚙️ Xuất bản</div>
                </div>
                <div class="card-body">
                    <div class="form-group" style="margin-bottom:16px;">
                        <label class="form-label">Trạng thái</label>
                        <select name="is_published" class="form-control">
                            <option value="1" {{ old('is_published', $post->is_published ? '1' : '0') == '1' ? 'selected' : '' }}>📢 Công khai</option>
                            <option value="0" {{ old('is_published', $post->is_published ? '1' : '0') == '0' ? 'selected' : '' }}>🔒 Ẩn (nháp)</option>
                        </select>
                    </div>
                    <div style="font-size:12px; color:var(--text-secondary); margin-bottom:16px;">
                        Tạo lúc: {{ $post->created_at->format('d/m/Y H:i') }}<br>
                        Cập nhật: {{ $post->updated_at->format('d/m/Y H:i') }}
                    </div>
                    <div style="display:flex; gap:10px; flex-direction:column;">
                        <button type="submit" class="btn btn-primary" style="justify-content:center; padding:12px;">
                            💾 Lưu thay đổi
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
function previewThumbnail(input) {
    const file = input.files[0];
    if (!file) return;
    if (file.size > 3 * 1024 * 1024) { alert('⚠️ Tối đa 3MB!'); input.value = ''; return; }
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('thumbnailImg').src = e.target.result;
        document.getElementById('thumbnailImg').style.display = 'block';
        const ph = document.getElementById('thumbnailPlaceholder');
        if (ph) ph.style.display = 'none';
        document.getElementById('removeThumbnail').value = '0';
    };
    reader.readAsDataURL(file);
}

function removeThumb() {
    if (!confirm('Xóa ảnh bìa hiện tại?')) return;
    document.getElementById('thumbnailImg').style.display = 'none';
    document.getElementById('thumbnailImg').src = '';
    const ph = document.getElementById('thumbnailPlaceholder');
    if (ph) ph.style.display = 'block';
    document.getElementById('thumbnailInput').value = '';
    document.getElementById('removeThumbnail').value = '1';
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

const excerptEl = document.querySelector('[name="excerpt"]');
const countEl   = document.getElementById('excerptCount');
if (excerptEl && countEl) {
    excerptEl.addEventListener('input', () => countEl.textContent = excerptEl.value.length);
}

const box = document.getElementById('thumbnailPreview');
const overlay = document.getElementById('thumbnailOverlay');
if (box && overlay) {
    box.addEventListener('mouseenter', () => { if (document.getElementById('thumbnailImg').style.display !== 'none') overlay.style.display = 'flex'; });
    box.addEventListener('mouseleave', () => { overlay.style.display = 'none'; });
}
</script>
@endpush

@endsection
