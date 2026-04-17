@extends('layouts.master')
@section('title', 'Ứng viên - ' . $task->title)

@section('content')
<div class="container" style="margin-top:32px; margin-bottom:60px;">
    <div style="margin-bottom:20px;">
        <a href="{{ route('employer.mini-tasks.index') }}" style="color:#64748b; font-size:14px; text-decoration:none;">← Danh sách dự án</a>
        <h1 style="font-size:20px; font-weight:800; color:#1e293b; margin-top:8px;">
            👥 Ứng viên: {{ $task->title }}
        </h1>
        <p style="font-size:13px; color:#64748b;">
            {{ $task->applications->count() }} ứng viên •
            {{ $task->acceptedApplications->count() }}/{{ $task->max_workers }} người được nhận •
            Ngân sách: {{ $task->budgetFormatted() }}
        </p>
    </div>

    @if(session('success'))
        <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:12px 16px; margin-bottom:16px; color:#166534; font-size:14px; font-weight:600;">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div style="background:#fef2f2; border:1px solid #fecaca; border-radius:8px; padding:12px 16px; margin-bottom:16px; color:#dc2626; font-size:14px; font-weight:600;">⚠️ {{ session('error') }}</div>
    @endif

    @if($task->applications->count() === 0)
        <div class="content-block" style="text-align:center; padding:60px; color:#94a3b8;">Chưa có ứng viên nào.</div>
    @else
    <div style="display:grid; gap:14px;">
        @foreach($task->applications as $app)
        <div class="content-block" style="padding:20px;">
            <div style="display:flex; gap:16px; align-items:flex-start; flex-wrap:wrap;">

                {{-- Avatar + Info --}}
                <div style="flex:1; min-width:240px;">
                    <div style="display:flex; align-items:center; gap:12px; margin-bottom:12px;">
                        <a href="{{ route('user.show', $app->user->id) }}" target="_blank" style="width:44px; height:44px; border-radius:50%; background:linear-gradient(135deg,#7c3aed,#4f46e5); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:800; font-size:18px; flex-shrink:0; text-decoration:none; overflow:hidden;">
                            @if($app->user->avatar)
                                <img src="{{ asset('storage/'.$app->user->avatar) }}" style="width:100%; height:100%; object-fit:cover;">
                            @else
                                {{ mb_substr($app->user->name, 0, 1) }}
                            @endif
                        </a>
                        <div>
                            <a href="{{ route('user.show', $app->user->id) }}" target="_blank" style="font-weight:700; color:#1e293b; font-size:15px; text-decoration:none;">{{ $app->user->name }}</a>
                            <div style="font-size:12px; color:#64748b;">{{ $app->user->email }}</div>
                        </div>
                        @php $badge = match($app->status) { 'pending'=>['#f59e0b','#fffbeb','⏳ Chờ duyệt'],'accepted'=>['#2563eb','#eff6ff','🔵 Đang thực hiện'],'rejected'=>['#dc2626','#fef2f2','❌ Từ chối'],'completed'=>['#16a34a','#f0fdf4','✅ Hoàn thành'], default=>['#64748b','#f1f5f9',$app->status] }; @endphp
                        <span style="background:{{ $badge[1] }}; color:{{ $badge[0] }}; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700;">{{ $badge[2] }}</span>

                        @if($app->user->is_student_verified)
                            <span style="background:#dcfce7; color:#166534; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700;">🎓 SV đã xác thực</span>
                        @endif
                    </div>

                    @if($app->cover_letter)
                        <div style="background:#f8fafc; border-radius:8px; padding:12px; font-size:13px; color:#374151; line-height:1.6; margin-bottom:10px;">
                            {{ $app->cover_letter }}
                        </div>
                    @endif

                    {{-- AI Summary --}}
                    @if($app->ai_summary)
                        <div style="background:linear-gradient(135deg,#f0f9ff,#e0f2fe); border:1px solid #bae6fd; border-radius:10px; padding:12px; margin-bottom:10px;">
                            <div style="display:flex; align-items:center; gap:6px; margin-bottom:6px;">
                                <span style="font-size:14px;">🤖</span>
                                <strong style="font-size:11px; text-transform:uppercase; letter-spacing:.5px; color:#0369a1;">AI Phân tích CV</strong>
                            </div>
                            <div style="font-size:12px; color:#0c4a6e; line-height:1.6; white-space:pre-line;">{{ $app->ai_summary }}</div>
                        </div>
                    @endif

                    @if($app->proposed_budget)
                        <div style="font-size:13px; color:#475569; margin-bottom:8px;">
                            💰 Đề xuất mức phí: <strong style="color:#7c3aed;">{{ number_format($app->proposed_budget) }}đ</strong>
                        </div>
                    @endif

                    {{-- CV đính kèm --}}
                    @if($app->cv_file)
                        <div style="margin-bottom:10px;">
                            @php $ext = pathinfo($app->cv_file, PATHINFO_EXTENSION); @endphp
                            <a href="{{ asset('storage/' . $app->cv_file) }}" target="_blank"
                               style="display:inline-flex; align-items:center; gap:6px; background:#f0fdf4; border:1px solid #bbf7d0;
                                      color:#166534; padding:6px 14px; border-radius:8px; font-size:13px; font-weight:700; text-decoration:none;">
                                @if(in_array(strtolower($ext), ['pdf']))
                                    📕 Xem CV (PDF)
                                @elseif(in_array(strtolower($ext), ['doc','docx']))
                                    📘 Xem CV (Word)
                                @else
                                    🖼️ Xem Portfolio
                                @endif
                            </a>
                        </div>
                    @else
                        <div style="font-size:12px; color:#94a3b8; margin-bottom:8px;">📎 Không đính kèm CV</div>
                    @endif

                    {{-- Progress (nếu đã accept) --}}
                    @if($app->status === 'accepted' || $app->status === 'completed')
                    <div>
                        <div style="display:flex; justify-content:space-between; font-size:12px; color:#475569; margin-bottom:4px;">
                            <span>Tiến độ</span><span>{{ $app->progress_percentage }}%</span>
                        </div>
                        <div style="background:#e2e8f0; border-radius:999px; height:8px; margin-bottom:6px;">
                            <div style="background:linear-gradient(90deg,#7c3aed,#4f46e5); height:8px; border-radius:999px; width:{{ $app->progress_percentage }}%;"></div>
                        </div>
                        @if($app->progress_notes)
                            <div style="font-size:12px; color:#64748b; font-style:italic;">{{ $app->progress_notes }}</div>
                        @endif
                    </div>
                    @endif

                    {{-- Thông tin ngân hàng của user — CHỈ hiện khi 100% --}}
                    @if($app->status === 'accepted' && $app->progress_percentage == 100)
                        @if($app->user->bank_account || $app->user->bank_qr_image)
                        <div style="margin-top:12px; padding:14px; background:#f0fdf4; border-radius:10px; border:1.5px solid #bbf7d0;">
                            <div style="font-size:12px; font-weight:700; color:#166534; margin-bottom:8px;">🏦 Thông tin nhận tiền của ứng viên</div>
                            @if($app->user->bank_account)
                                <div style="font-size:14px; font-weight:800; color:#1e293b; letter-spacing:1px;">{{ $app->user->bank_account }}</div>
                                @if($app->user->bank_account_name)
                                    <div style="font-size:12px; font-weight:700; color:#1e293b; margin-top:2px;">Chủ TK: {{ $app->user->bank_account_name }}</div>
                                @endif
                                <div style="font-size:12px; color:#16a34a; margin-top:2px;">{{ $app->user->bank_name }}</div>
                            @endif
                            @if($app->user->bank_qr_image)
                                <a href="{{ asset('storage/'.$app->user->bank_qr_image) }}" target="_blank">
                                    <img src="{{ asset('storage/'.$app->user->bank_qr_image) }}" alt="QR"
                                         style="width:100px; height:100px; object-fit:contain; margin-top:8px; border-radius:8px; border:2px solid #bbf7d0;">
                                </a>
                                <div style="font-size:11px; color:#16a34a; margin-top:4px;">Click để phóng to QR</div>
                            @endif
                        </div>
                        @endif
                    @elseif($app->status === 'accepted' && $app->progress_percentage < 100)
                        <div style="margin-top:12px; padding:10px 12px; background:#faf5ff; border-radius:8px; border:1px dashed #c4b5fd; font-size:12px; color:#7c3aed;">
                            🔒 Thông tin thanh toán sẽ hiện khi ứng viên hoàn thành 100%<br>
                            <span style="color:#94a3b8;">Tiến độ hiện tại: <strong style="color:#7c3aed;">{{ $app->progress_percentage }}%</strong></span>
                        </div>
                    @endif
                </div>

                {{-- Actions --}}
                <div style="min-width:200px; display:flex; flex-direction:column; gap:10px;">

                    @if($app->status === 'pending')
                        @if(!$task->isFull())
                        <form action="{{ route('employer.mini-tasks.application.accept', $app->id) }}" method="POST">
                            @csrf
                            <button type="submit" style="width:100%; background:#2563eb; color:#fff; border:none; padding:10px; border-radius:8px; font-weight:700; font-size:13px; cursor:pointer;">
                                ✅ Nhận ứng viên
                            </button>
                        </form>
                        @endif
                        <form action="{{ route('employer.mini-tasks.application.reject', $app->id) }}" method="POST">
                            @csrf
                            <button type="submit" style="width:100%; background:#fee2e2; color:#dc2626; border:none; padding:10px; border-radius:8px; font-weight:700; font-size:13px; cursor:pointer;">
                                ❌ Từ chối
                            </button>
                        </form>
                    @endif

                    @if($app->status === 'accepted' && !$app->payment_proof)
                        @if($app->progress_percentage == 100)
                        {{-- Form xác nhận thanh toán — CHỈ hiện khi 100% --}}
                        <div style="background:#f0fdf4; border:1.5px solid #bbf7d0; border-radius:10px; padding:14px;">
                            <div style="font-size:13px; font-weight:700; color:#166534; margin-bottom:10px;">💳 Xác nhận thanh toán</div>
                            <div style="font-size:11px; color:#16a34a; margin-bottom:10px;">✅ Ứng viên đã hoàn thành 100%!</div>
                            <form action="{{ route('employer.mini-tasks.application.payment', $app->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div style="margin-bottom:8px;">
                                    <label style="font-size:11px; font-weight:600; color:#475569;">Số tiền thanh toán (đ)</label>
                                    <input type="number" name="payment_amount" min="0" required
                                           placeholder="{{ $app->proposed_budget ?? $task->budget_min }}"
                                           style="width:100%; padding:8px; border:1.5px solid #bbf7d0; border-radius:6px; font-size:13px; margin-top:4px;">
                                </div>
                                <div style="margin-bottom:8px;">
                                    <label style="font-size:11px; font-weight:600; color:#475569;">Ảnh bill thanh toán <span style="color:#ef4444;">*</span></label>
                                    <input type="file" name="payment_proof" accept="image/*" required
                                           style="width:100%; padding:6px; border:1.5px solid #bbf7d0; border-radius:6px; font-size:12px; margin-top:4px;">
                                </div>
                                <div style="margin-bottom:10px;">
                                    <label style="font-size:11px; font-weight:600; color:#475569;">Ghi chú</label>
                                    <input type="text" name="payment_note" placeholder="Tùy chọn"
                                           style="width:100%; padding:8px; border:1.5px solid #bbf7d0; border-radius:6px; font-size:13px; margin-top:4px;">
                                </div>
                                <button type="submit" style="width:100%; background:#16a34a; color:#fff; border:none; padding:10px; border-radius:8px; font-weight:700; font-size:13px; cursor:pointer;">
                                    ✅ Xác nhận & Upload bill
                                </button>
                            </form>
                        </div>
                        @else
                        {{-- Chưa 100% — hiện hint cho employer --}}
                        <div style="background:#faf5ff; border:1px dashed #c4b5fd; border-radius:10px; padding:14px; text-align:center;">
                            <div style="font-size:20px; margin-bottom:6px;">🔒</div>
                            <div style="font-size:12px; font-weight:700; color:#5b21b6;">Thanh toán khi hoàn thành 100%</div>
                            <div style="font-size:11px; color:#94a3b8; margin-top:4px;">Tiến độ: <strong style="color:#7c3aed;">{{ $app->progress_percentage }}%</strong></div>
                            <div style="background:#ede9fe; border-radius:999px; height:5px; margin-top:8px;">
                                <div style="background:linear-gradient(90deg,#7c3aed,#4f46e5); height:5px; border-radius:999px; width:{{ $app->progress_percentage }}%;"></div>
                            </div>
                        </div>
                        @endif
                    @endif

                    @if($app->payment_proof)
                        <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:12px; text-align:center;">
                            <div style="font-size:13px; font-weight:700; color:#166534; margin-bottom:6px;">✅ Đã thanh toán</div>
                            <div style="font-size:12px; color:#475569; margin-bottom:6px;">{{ number_format($app->payment_amount) }}đ</div>
                            <a href="{{ asset('storage/'.$app->payment_proof) }}" target="_blank"
                               style="font-size:12px; color:#16a34a; font-weight:600; text-decoration:none;">🧾 Xem bill →</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
