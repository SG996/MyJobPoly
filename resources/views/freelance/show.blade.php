@extends('layouts.master')
@section('title', $task->title . ' | Freelance MyJobCV')

@section('content')
<div class="container" style="margin-top:28px; margin-bottom:60px;">

    {{-- Breadcrumb --}}
    <div class="breadcrumb" style="margin-bottom:20px;">
        <a href="{{ url('/') }}">Trang chủ</a> /
        <a href="{{ route('freelance.index') }}">Freelance</a> /
        <span>{{ Str::limit($task->title, 50) }}</span>
    </div>

    <div class="job-detail-grid">
        {{-- ===== MAIN ===== --}}
        <div class="main-content">

            {{-- Flash messages --}}
            @if(session('success'))
                <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:14px 18px; margin-bottom:18px; color:#166534; font-size:14px; font-weight:600;">
                    ✅ {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="background:#fef2f2; border:1px solid #fecaca; border-radius:8px; padding:14px 18px; margin-bottom:18px; color:#991b1b; font-size:14px; font-weight:600;">
                    ⚠️ {{ session('error') }}
                </div>
            @endif

            <div class="content-block">
                {{-- Header dự án --}}
                <div style="display:flex; align-items:flex-start; gap:16px; margin-bottom:24px; padding-bottom:20px; border-bottom:1px solid #e2e8f0;">
                    <div style="flex:1;">
                        <div style="display:flex; align-items:center; gap:10px; margin-bottom:10px;">
                            <span class="fl-type-badge {{ $task->type === 'internship' ? 'internship' : 'freelance' }}" style="font-size:13px; padding:5px 14px;">
                                {{ $task->type === 'internship' ? '🎓 Thực tập' : '💼 Freelance' }}
                            </span>
                            @if($task->type === 'internship')
                                <span style="background:#fef3c7; color:#92400e; font-size:11px; font-weight:700; padding:3px 10px; border-radius:20px; border:1px solid #fde68a;">
                                    🔒 Yêu cầu xác thực sinh viên
                                </span>
                            @endif
                        </div>
                        <h1 style="font-size:24px; font-weight:800; color:#1e293b; margin-bottom:8px; line-height:1.3;">
                            {{ $task->title }}
                        </h1>
                        <div style="font-size:13px; color:#64748b;">
                            Mã dự án #{{ $task->id }} •
                            Đăng {{ $task->created_at->format('d/m/Y, H:i') }} •
                            Còn <span style="color:#ef4444; font-weight:700;">{{ $task->timeRemaining() }}</span>
                        </div>
                    </div>
                </div>

                {{-- Grid thông tin --}}
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:28px;">
                    <div class="fl-detail-item">
                        <div class="fl-detail-label">Ngân sách</div>
                        <div class="fl-detail-value" style="color:#7c3aed; font-size:18px;">
                            💰 {{ $task->budgetFormatted() }}
                        </div>
                    </div>
                    <div class="fl-detail-item">
                        <div class="fl-detail-label">Hình thức làm việc</div>
                        <div class="fl-detail-value">🖥️ {{ $task->workTypeLabel() }}</div>
                    </div>
                    <div class="fl-detail-item">
                        <div class="fl-detail-label">Địa điểm</div>
                        <div class="fl-detail-value">📍 {{ $task->location }}</div>
                    </div>
                    <div class="fl-detail-item">
                        <div class="fl-detail-label">Hình thức trả lương</div>
                        <div class="fl-detail-value">💳 {{ $task->paymentTypeLabel() }}</div>
                    </div>
                    <div class="fl-detail-item">
                        <div class="fl-detail-label">Số người cần tuyển</div>
                        <div class="fl-detail-value">
                            👥 {{ $acceptedCount }}/{{ $task->max_workers }} người
                            @if($task->isFull())
                                <span style="color:#ef4444; font-size:12px; font-weight:700; margin-left:6px;">(Đã đủ)</span>
                            @else
                                <span style="color:#16a34a; font-size:12px; font-weight:700; margin-left:6px;">(Còn {{ $task->remainingSlots() }} chỗ)</span>
                            @endif
                        </div>
                    </div>
                    <div class="fl-detail-item">
                        <div class="fl-detail-label">Hạn nộp</div>
                        <div class="fl-detail-value" style="color:#ef4444;">
                            📅 {{ $task->deadline->format('d/m/Y, H:i') }}
                        </div>
                    </div>
                </div>

                {{-- Mô tả --}}
                <h2 style="font-size:18px; font-weight:700; color:#1e293b; border-left:4px solid #7c3aed; padding-left:12px; margin-bottom:14px;">
                    Mô tả dự án
                </h2>
                <div style="color:#374151; line-height:1.85; margin-bottom:24px; font-size:15px;">
                    {!! nl2br(e($task->description)) !!}
                </div>

                @if($task->requirements)
                <h2 style="font-size:18px; font-weight:700; color:#1e293b; border-left:4px solid #7c3aed; padding-left:12px; margin-bottom:14px;">
                    Yêu cầu kỹ năng
                </h2>
                <div style="color:#374151; line-height:1.85; margin-bottom:24px; font-size:15px;">
                    {!! nl2br(e($task->requirements)) !!}
                </div>
                @endif

                {{-- Form ứng tuyển --}}
                @auth
                    @if(auth()->user()->role == 0)

                        @if($task->type === 'internship' && !auth()->user()->is_student_verified)
                            {{-- Cảnh báo cần xác thực --}}
                            <div style="background:#fffbeb; border:1.5px solid #fde68a; border-radius:12px; padding:20px; text-align:center;">
                                <div style="font-size:32px; margin-bottom:10px;">🎓</div>
                                <h3 style="color:#92400e; font-size:16px; font-weight:700; margin-bottom:8px;">Cần xác thực sinh viên</h3>
                                <p style="color:#78350f; font-size:14px; margin-bottom:16px;">
                                    Vị trí thực tập yêu cầu bạn phải xác thực sinh viên trước khi ứng tuyển.
                                </p>
                                <a href="{{ route('account.verify_student') }}"
                                   style="background:#f59e0b; color:#fff; padding:12px 24px; border-radius:8px;
                                          font-weight:700; font-size:14px; text-decoration:none;">
                                    Xác thực sinh viên ngay →
                                </a>
                            </div>

                        @elseif($hasApplied)
                            {{-- Đã ứng tuyển --}}
                            <div style="background:#f0fdf4; border:1.5px solid #bbf7d0; border-radius:12px; padding:24px;">
                                <h3 style="color:#166534; font-size:16px; font-weight:700; margin-bottom:12px;">✅ Bạn đã ứng tuyển dự án này</h3>
                                <div style="display:flex; align-items:center; gap:12px; margin-bottom:14px;">
                                    <span style="font-size:13px; color:#64748b;">Trạng thái:</span>
                                    <span class="status-badge-{{ $myApplication->statusColor() }}">
                                        {{ $myApplication->statusLabel() }}
                                    </span>
                                </div>
                                @if($myApplication->status === 'accepted')
                                    <div style="margin-top:16px;">
                                        <div style="font-size:13px; font-weight:600; color:#1e293b; margin-bottom:8px;">
                                            Tiến độ hiện tại: {{ $myApplication->progress_percentage }}%
                                        </div>
                                        <div style="background:#e2e8f0; border-radius:999px; height:8px; margin-bottom:16px;">
                                            <div style="background:linear-gradient(90deg,#7c3aed,#4f46e5); height:8px; border-radius:999px; width:{{ $myApplication->progress_percentage }}%;"></div>
                                        </div>
                                        <form action="{{ route('freelance.progress', $myApplication->id) }}" method="POST">
                                            @csrf
                                            <div style="display:grid; gap:12px;">
                                                <div>
                                                    <label style="font-size:13px; font-weight:600; color:#1e293b; display:block; margin-bottom:6px;">
                                                        Cập nhật tiến độ (%)
                                                    </label>
                                                    <input type="number" name="progress_percentage" min="0" max="100"
                                                           value="{{ $myApplication->progress_percentage }}"
                                                           style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:14px;">
                                                </div>
                                                <div>
                                                    <label style="font-size:13px; font-weight:600; color:#1e293b; display:block; margin-bottom:6px;">
                                                        Ghi chú tiến độ
                                                    </label>
                                                    <textarea name="progress_notes" rows="3"
                                                              placeholder="Mô tả những gì bạn đã thực hiện..."
                                                              style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:14px; resize:vertical;">{{ $myApplication->progress_notes }}</textarea>
                                                </div>
                                                <button type="submit"
                                                        style="background:linear-gradient(135deg,#7c3aed,#4f46e5); color:#fff; border:none; padding:12px 24px; border-radius:8px; font-weight:700; font-size:14px; cursor:pointer;">
                                                    💾 Cập nhật tiến độ
                                                </button>
                                            </div>
                                        </form>

                                        {{-- Thông tin thanh toán user — chỉ hiện khi 100% --}}
                                        @if($myApplication->progress_percentage == 100)
                                            @if(!$myApplication->payment_proof)
                                                @if(auth()->user()->bank_account || auth()->user()->bank_qr_image)
                                                    <div style="margin-top:20px; padding:18px; background:#f0fdf4; border-radius:12px; border:1.5px solid #bbf7d0;">
                                                        <h4 style="font-size:14px; font-weight:700; color:#166534; margin-bottom:12px;">
                                                            🏦 Thông tin nhận thanh toán của bạn
                                                        </h4>
                                                        <p style="font-size:12px; color:#16a34a; margin-bottom:12px;">
                                                            ✅ Hoàn thành 100%! Chia sẻ thông tin này với nhà tuyển dụng để nhận thanh toán.
                                                        </p>
                                                        @if(auth()->user()->bank_account)
                                                            <div style="background:#fff; border-radius:8px; padding:12px; border:1px solid #d1fae5; margin-bottom:10px;">
                                                                <div style="font-size:12px; color:#64748b; margin-bottom:2px;">Số tài khoản</div>
                                                                <div style="font-size:16px; font-weight:800; color:#1e293b; letter-spacing:1px;">{{ auth()->user()->bank_account }}</div>
                                                                @if(auth()->user()->bank_account_name)
                                                                    <div style="font-size:12px; color:#1e293b; font-weight:700; margin-top:4px;">Chủ TK: {{ auth()->user()->bank_account_name }}</div>
                                                                @endif
                                                                @if(auth()->user()->bank_name)
                                                                    <div style="font-size:12px; color:#16a34a; margin-top:2px;">{{ auth()->user()->bank_name }}</div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                        @if(auth()->user()->bank_qr_image)
                                                            <div style="text-align:center;">
                                                                <div style="font-size:12px; color:#64748b; margin-bottom:6px;">QR chuyển tiền</div>
                                                                <img src="{{ asset('storage/' . auth()->user()->bank_qr_image) }}" alt="QR thanh toán"
                                                                     style="width:160px; height:160px; object-fit:contain; border-radius:10px; border:2px solid #bbf7d0;">
                                                            </div>
                                                        @endif
                                                    </div>
                                                @else
                                                    <div style="margin-top:16px; padding:14px; background:#fef3c7; border-radius:10px; border:1px solid #fde68a;">
                                                        <p style="font-size:13px; color:#92400e; margin-bottom:8px;">
                                                            ⚠️ Bạn chưa thêm thông tin tài khoản ngân hàng. Thêm ngay để nhận thanh toán!
                                                        </p>
                                                        <a href="{{ route('account.verify_student') }}"
                                                           style="font-size:13px; color:#d97706; font-weight:700; text-decoration:underline;">
                                                            Cập nhật thông tin thanh toán →
                                                        </a>
                                                    </div>
                                                @endif
                                            @else
                                                <div style="margin-top:20px; padding:16px; background:#f0fdf4; border-radius:10px; border:1px solid #bbf7d0;">
                                                    <h4 style="font-size:14px; font-weight:700; color:#166534; margin-bottom:8px;">✅ Đã được thanh toán</h4>
                                                    <p style="font-size:13px; color:#374151;">Số tiền: <strong>{{ number_format($myApplication->payment_amount) }}đ</strong></p>
                                                    <a href="{{ asset('storage/' . $myApplication->payment_proof) }}" target="_blank"
                                                       style="display:inline-block; margin-top:8px; font-size:13px; color:#16a34a; font-weight:600; text-decoration:none;">
                                                        🧾 Xem ảnh bill thanh toán →
                                                    </a>
                                                </div>
                                            @endif
                                        @else
                                            {{-- Chưa 100% — hiện hint --}}
                                            <div style="margin-top:20px; padding:14px 16px; background:#faf5ff; border-radius:10px; border:1px dashed #c4b5fd;">
                                                <div style="display:flex; align-items:center; gap:10px;">
                                                    <span style="font-size:24px;">🔒</span>
                                                    <div>
                                                        <div style="font-size:13px; font-weight:700; color:#5b21b6;">Thông tin thanh toán sẽ hiện khi bạn hoàn thành 100%</div>
                                                        <div style="font-size:12px; color:#7c3aed; margin-top:2px;">
                                                            Tiến độ hiện tại: <strong>{{ $myApplication->progress_percentage }}%</strong> — Cần thêm {{ 100 - $myApplication->progress_percentage }}%
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- Progress mini bar --}}
                                                <div style="background:#ede9fe; border-radius:999px; height:6px; margin-top:10px;">
                                                    <div style="background:linear-gradient(90deg,#7c3aed,#4f46e5); height:6px; border-radius:999px;
                                                                width:{{ $myApplication->progress_percentage }}%; transition:width .5s;">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>

                        @elseif(!$task->isFull() && $task->status === 'open')
                            {{-- Form ứng tuyển --}}
                            <div style="background:#f5f3ff; border:1.5px solid #ddd6fe; border-radius:12px; padding:24px;">
                                <h3 style="font-size:16px; font-weight:700; color:#5b21b6; margin-bottom:16px;">
                                    📝 Ứng tuyển dự án này
                                </h3>
                                <form action="{{ route('freelance.apply', $task->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div style="display:grid; gap:14px;">
                                        <div>
                                            <label style="font-size:13px; font-weight:600; color:#1e293b; display:block; margin-bottom:6px;">
                                                Giới thiệu bản thân & Kinh nghiệm
                                            </label>
                                            <textarea id="cover_letter_input" name="cover_letter" rows="4" required
                                                      placeholder="Mô tả kỹ năng liên quan của bạn và lý do bạn phù hợp với dự án này..."
                                                      style="width:100%; padding:12px 14px; border:1.5px solid #ddd6fe; border-radius:8px; font-size:14px; resize:vertical; background:#fff;">{{ old('cover_letter') }}</textarea>

                                            {{-- AI Suggest Button --}}
                                            <div style="margin-top:8px; display:flex; align-items:center; gap:10px;">
                                                <button type="button" id="ai-suggest-btn"
                                                        onclick="aiSuggestCoverLetter()"
                                                        style="display:inline-flex; align-items:center; gap:6px; background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff; border:none; padding:8px 16px; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; transition:all .2s;">
                                                    ✨ Gợi ý AI cải thiện
                                                </button>
                                                <span id="ai-loading" style="display:none; font-size:13px; color:#7c3aed;">🔄 AI đang phân tích...</span>
                                            </div>

                                            {{-- AI Result Panel --}}
                                            <div id="ai-result-panel" style="display:none; margin-top:12px; background:linear-gradient(135deg,#f5f3ff,#ede9fe); border:1.5px solid #c4b5fd; border-radius:10px; padding:14px;">
                                                <div style="display:flex; align-items:center; gap:6px; margin-bottom:8px;">
                                                    <span style="font-size:16px;">🤖</span>
                                                    <strong style="font-size:12px; text-transform:uppercase; letter-spacing:.5px; color:#5b21b6;">Gợi ý từ Gemini AI</strong>
                                                </div>
                                                <div id="ai-result-text" style="font-size:13px; color:#3b0764; line-height:1.7; white-space:pre-line;"></div>
                                            </div>
                                        </div>
                                        <div>
                                            <label style="font-size:13px; font-weight:600; color:#1e293b; display:block; margin-bottom:6px;">
                                                Đề xuất mức phí (VNĐ) <span style="color:#94a3b8; font-weight:400;">– Tùy chọn</span>
                                            </label>
                                            <input type="number" name="proposed_budget" min="0"
                                                   placeholder="Ví dụ: 2000000"
                                                   style="width:100%; padding:12px 14px; border:1.5px solid #ddd6fe; border-radius:8px; font-size:14px; background:#fff;">
                                        </div>

                                        {{-- CV Upload --}}
                                        <div>
                                            <label style="font-size:13px; font-weight:600; color:#1e293b; display:block; margin-bottom:6px;">
                                                📎 Đính kèm CV / Portfolio
                                                <span style="color:#94a3b8; font-weight:400;">– PDF, Word, ảnh (tối đa 5MB)</span>
                                            </label>
                                            <div id="cv-dropzone"
                                                 onclick="document.getElementById('cv_file_input').click()"
                                                 style="border:2px dashed #ddd6fe; border-radius:10px; padding:20px; text-align:center;
                                                        cursor:pointer; background:#faf9ff; transition:all .2s;"
                                                 onmouseover="this.style.borderColor='#7c3aed';this.style.background='#f5f3ff'"
                                                 onmouseout="this.style.borderColor='#ddd6fe';this.style.background='#faf9ff'">
                                                <div style="font-size:28px; margin-bottom:6px;">📄</div>
                                                <div style="font-size:13px; color:#6d28d9; font-weight:600;">Click để chọn file CV</div>
                                                <div id="cv-filename" style="font-size:12px; color:#7c3aed; margin-top:4px; font-weight:700;"></div>
                                            </div>
                                            <input type="file" id="cv_file_input" name="cv_file"
                                                   accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                                   style="display:none;"
                                                   onchange="document.getElementById('cv-filename').textContent='✓ ' + this.files[0].name">
                                            @error('cv_file')
                                                <div style="color:#ef4444; font-size:12px; margin-top:4px;">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <button type="submit"
                                                style="background:linear-gradient(135deg,#7c3aed,#4f46e5); color:#fff; border:none; padding:14px 24px;
                                                       border-radius:8px; font-weight:700; font-size:15px; cursor:pointer; transition:all .2s;"
                                                onmouseover="this.style.opacity='.9'" onmouseout="this.style.opacity='1'">
                                            🚀 Gửi ứng tuyển
                                        </button>
                                    </div>
                                </form>
                            </div>

                        @elseif($task->isFull())
                            <div style="background:#fef2f2; border:1px solid #fecaca; border-radius:10px; padding:16px; text-align:center; color:#991b1b; font-weight:600;">
                                Dự án này đã đủ số lượng người thực hiện.
                            </div>
                        @endif
                    @endif
                @else
                    <div style="background:#f5f3ff; border:1.5px solid #ddd6fe; border-radius:12px; padding:24px; text-align:center;">
                        <p style="color:#6d28d9; font-weight:600; margin-bottom:14px;">Đăng nhập để ứng tuyển dự án này</p>
                        <a href="{{ route('login') }}"
                           style="background:linear-gradient(135deg,#7c3aed,#4f46e5); color:#fff; padding:12px 28px; border-radius:8px; font-weight:700; text-decoration:none;">
                            Đăng nhập ngay →
                        </a>
                    </div>
                @endauth

            </div>
        </div>

        {{-- ===== SIDEBAR ===== --}}
        <aside class="sidebar">
            {{-- Thông tin khách hàng --}}
            <div class="content-block sidebar-block">
                <h3>👤 Thông tin khách hàng</h3>
                <div style="text-align:center; padding:16px 0;">
                    @if(optional($task->employer)->company)
                        <a href="{{ route('company.show', $task->employer->company->id) }}" style="text-decoration:none; display:block;">
                    @else
                        <div style="display:block;">
                    @endif

                    @if(optional(optional($task->employer)->company)->logo)
                        <img src="{{ asset('storage/' . $task->employer->company->logo) }}"
                             style="width:72px; height:72px; border-radius:50%; object-fit:cover; border:3px solid #e2e8f0; margin-bottom:10px; transition:transform .2s;"
                             onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    @else
                        <div style="width:72px; height:72px; border-radius:50%; background:linear-gradient(135deg,#7c3aed,#4f46e5);
                                    display:flex; align-items:center; justify-content:center; margin:0 auto 10px;
                                    font-size:28px; font-weight:800; color:#fff; transition:transform .2s;"
                             onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                            {{ mb_substr(optional(optional($task->employer)->company)->name ?? $task->employer->name, 0, 1) }}
                        </div>
                    @endif
                    <div style="font-size:15px; font-weight:700; color:#1e293b; text-decoration:none;">
                        {{ optional(optional($task->employer)->company)->name ?? $task->employer->name }}
                        @if(optional($task->employer)->company) <span style="color:#7c3aed; font-size:12px;">🔗</span> @endif
                    </div>
                    <div style="font-size:12px; color:#64748b; margin-top:4px;">
                        Tham gia {{ $task->employer->created_at->format('d/m/Y') }}
                    </div>

                    @if(optional($task->employer)->company)
                        </a>
                    @else
                        </div>
                    @endif
                </div>
                <div style="border-top:1px solid #e2e8f0; padding-top:14px; margin-top:6px;">
                    <div style="font-size:13px; color:#475569; margin-bottom:6px;">
                        📍 {{ optional(optional($task->employer)->company)->address ?: 'Toàn quốc' }}
                    </div>
                    <div style="font-size:13px; color:#475569;">
                        💼 {{ $task->employer->miniTasks()->count() }} dự án đã đăng
                    </div>
                </div>
            </div>

            {{-- Thông tin dự án --}}
            <div class="content-block sidebar-block">
                <h3>📋 Thông tin dự án</h3>
                <table style="width:100%; font-size:13px; border-collapse:collapse;">
                    <tr style="border-bottom:1px solid #e2e8f0;">
                        <td style="padding:8px 0; color:#64748b;">ID dự án</td>
                        <td style="padding:8px 0; font-weight:600; text-align:right;">{{ $task->id }}</td>
                    </tr>
                    <tr style="border-bottom:1px solid #e2e8f0;">
                        <td style="padding:8px 0; color:#64748b;">Ngày đăng</td>
                        <td style="padding:8px 0; font-weight:600; text-align:right;">{{ $task->created_at->format('d/m/Y') }}</td>
                    </tr>
                    <tr style="border-bottom:1px solid #e2e8f0;">
                        <td style="padding:8px 0; color:#64748b;">Chỉ còn</td>
                        <td style="padding:8px 0; font-weight:600; color:#ef4444; text-align:right;">{{ $task->timeRemaining() }}</td>
                    </tr>
                    <tr style="border-bottom:1px solid #e2e8f0;">
                        <td style="padding:8px 0; color:#64748b;">Địa điểm</td>
                        <td style="padding:8px 0; font-weight:600; text-align:right;">{{ $task->location }}</td>
                    </tr>
                    <tr style="border-bottom:1px solid #e2e8f0;">
                        <td style="padding:8px 0; color:#64748b;">Ngân sách</td>
                        <td style="padding:8px 0; font-weight:600; color:#7c3aed; text-align:right;">{{ $task->budgetFormatted() }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0; color:#64748b;">Ứng tuyển</td>
                        <td style="padding:8px 0; font-weight:600; text-align:right;">{{ $task->applications()->count() }} người</td>
                    </tr>
                </table>
            </div>
        </aside>
    </div>
</div>

<style>
.fl-detail-item { background:#f8fafc; border-radius:10px; padding:14px; border:1px solid #e2e8f0; }
.fl-detail-label { font-size:11px; color:#64748b; font-weight:600; margin-bottom:4px; text-transform:uppercase; letter-spacing:.5px; }
.fl-detail-value { font-size:15px; font-weight:700; color:#1e293b; }
.fl-type-badge { font-size:11px; font-weight:700; padding:4px 10px; border-radius:20px; }
.fl-type-badge.freelance { background:#eff6ff; color:#2563eb; }
.fl-type-badge.internship { background:#f0fdf4; color:#16a34a; }
.status-badge-warning { background:#fef3c7; color:#92400e; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:700; }
.status-badge-info { background:#dbeafe; color:#1e40af; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:700; }
.status-badge-success { background:#dcfce7; color:#166534; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:700; }
.status-badge-danger { background:#fee2e2; color:#991b1b; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:700; }
</style>

<script>
// =====================================================================
// AI: Gợi ý cải thiện Cover Letter
// =====================================================================
function aiSuggestCoverLetter() {
    const textarea = document.getElementById('cover_letter_input');
    const text = textarea ? textarea.value.trim() : '';

    if (!text || text.length < 20) {
        alert('Vui lòng nhập ít nhất 20 ký tự vào thư giới thiệu trước khi gợi ý AI.');
        return;
    }

    const btn     = document.getElementById('ai-suggest-btn');
    const loading = document.getElementById('ai-loading');
    const panel   = document.getElementById('ai-result-panel');
    const result  = document.getElementById('ai-result-text');

    btn.disabled = true;
    btn.style.opacity = '0.6';
    loading.style.display = 'inline';
    panel.style.display   = 'none';

    fetch('{{ route("ai.suggest") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({
            text:      text,
            job_title: '{{ addslashes($task->title) }}',
        }),
    })
    .then(res => res.json())
    .then(data => {
        loading.style.display = 'none';
        btn.disabled = false;
        btn.style.opacity = '1';

        if (data.success && data.suggestion) {
            result.textContent = data.suggestion;
            panel.style.display = 'block';
            panel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } else if (data.code === 'ai_unavailable') {
            // Hiện thông báo trong panel thay vì alert
            result.textContent = '⚠️ ' + (data.message || 'AI tạm thời không khả dụng. Vui lòng thử lại sau hoặc tự viết thư giới thiệu.');
            panel.style.background = 'linear-gradient(135deg,#fef3c7,#fde68a)';
            panel.style.borderColor = '#f59e0b';
            panel.style.display = 'block';
            // Reset màu về sau 5 giây
            setTimeout(() => {
                panel.style.background = 'linear-gradient(135deg,#f5f3ff,#ede9fe)';
                panel.style.borderColor = '#c4b5fd';
            }, 5000);
        } else {
            alert(data.message || 'Không thể lấy gợi ý từ AI. Vui lòng thử lại.');
        }
    })
    .catch(() => {
        loading.style.display = 'none';
        btn.disabled = false;
        btn.style.opacity = '1';
        alert('Lỗi kết nối. Vui lòng thử lại.');
    });
}
</script>
@endsection
