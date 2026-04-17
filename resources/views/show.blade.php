@extends('layouts.master')

@section('title', $job->title . ' | MyJobCV')

@section('content')
    <div class="container job-detail-grid">
        <div class="main-content">

            <div class="content-block job-card-detailed">
                @if(session('success'))
                    <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                        {{ session('error') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <h1 class="job-detailed-title">{{ $job->title }}</h1>

                <div class="job-info-grid">
                    <div class="info-item-detailed">
                        <div class="icon-circle">
                            <span class="icon-text">$</span>
                        </div>
                        <div class="info-text-group">
                            <div class="info-label" style="color: #7f878f; font-size: 14px;">Thu nhập</div>
                            <div class="info-value" style="font-weight: 600; font-size: 15px;">{{ $job->salary }}</div>
                        </div>
                    </div>
                    <div class="info-item-detailed">
                        <div class="icon-circle">
                            <span class="icon-text">P</span>
                        </div>
                        <div class="info-text-group">
                            <div class="info-label" style="color: #7f878f; font-size: 14px;">Địa điểm</div>
                            <div class="info-value text-primary" style="font-weight: 600; font-size: 15px;">{{ $job->location }}</div>
                        </div>
                    </div>
                    <div class="info-item-detailed">
                        <div class="icon-circle">
                            <span class="icon-text">8</span>
                        </div>
                        <div class="info-text-group">
                            <div class="info-label" style="color: #7f878f; font-size: 14px;">Kinh nghiệm</div>
                            <div class="info-value" style="font-weight: 600; font-size: 15px;">{{ $job->experience }}</div>
                        </div>
                    </div>
                </div>

                @php
                    $daysLeft = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($job->deadline), false);
                @endphp
                <p class="deadline-text">Hạn nộp hồ sơ: {{ \Carbon\Carbon::parse($job->deadline)->format('d/m/Y') }}
                    @if($daysLeft > 0)
                        (Còn {{ intval($daysLeft) }} ngày)
                    @else
                        <span style="color:red;">(Đã hết hạn)</span>
                    @endif
                </p>

                <div class="action-buttons-group" style="display: flex; gap: 10px;">
                    @auth
                        @php
                            $hasApplied = \App\Models\Application::where('user_id', Auth::id())->where('job_id', $job->id)->exists();
                        @endphp
                        @if($hasApplied)
                            <button disabled class="btn btn-apply-detailed" style="background:#28a745; color:white; border:none; cursor:not-allowed;">
                                <span class="btn-icon">✓</span> Đã ứng tuyển
                            </button>
                        @else
                            <a href="#" onclick="event.preventDefault(); document.getElementById('applyModal').style.display='block';" class="btn btn-apply-detailed btn-primary">
                                <span class="btn-icon">✈</span> Ứng tuyển ngay
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-apply-detailed btn-primary">
                            <span class="btn-icon">✈</span> Ứng tuyển ngay
                        </a>
                    @endauth
                    
                    @php
                        $isApplied = in_array($job->id, session('saved_jobs', []));
                    @endphp
                    <form action="{{ route('job.save', $job->id) }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn btn-save-detailed {{ $isApplied ? 'btn-danger' : 'btn-outline' }}" style="{{ $isApplied ? 'color:white; border-color: #dc3545;' : '' }}">
                            <span class="btn-icon-save" style="margin-right: 5px;">{!! $isApplied ? '❤️' : '♡' !!}</span> {{ $isApplied ? 'Đã lưu' : 'Lưu tin' }}
                        </button>
                    </form>
                </div>
            </div>

            <div class="content-block info-summary">
                <table class="info-summary-table">
                    <tr>
                        <td>Lương<br><strong>{{ $job->salary }}</strong></td>
                        <td>Hình thức làm việc<br><strong>Toàn thời gian</strong></td>
                        <td>Cấp bậc<br><strong>{{ $job->level ?? 'Nhân viên' }}</strong></td>
                        <td>Kinh nghiệm<br><strong>{{ $job->experience }}</strong></td>
                    </tr>
                    <tr>
                        <td>Yêu cầu<br><strong>{{ $job->quantity ? $job->quantity . ' người' : 'Không giới hạn' }}</strong></td>
                        <td>Danh mục<br><strong>{{ optional($job->category)->name }}</strong></td>
                        <td>Bằng cấp<br><strong>{{ $job->degree ?? 'Không yêu cầu' }}</strong></td>
                        <td>Ngày cập nhật<br><strong>{{ $job->created_at->format('d/m/Y') }}</strong></td>
                    </tr>
                </table>
            </div>

            <div class="content-block description-section">
                <h2>Chi tiết công việc</h2>
                <div style="line-height: 1.8; color: #333; margin-bottom: 25px;">
                    {!! nl2br(e($job->description)) !!}
                </div>

                <h2>Yêu cầu ứng viên</h2>
                <div style="line-height: 1.8; color: #333; margin-bottom: 25px;">
                    {!! nl2br(e($job->requirements)) !!}
                </div>

                <h2>Quyền lợi được hưởng</h2>
                <div style="line-height: 1.8; color: #333;">
                    {!! nl2br(e($job->benefits)) !!}
                </div>
            </div>
        </div>

        <aside class="sidebar">
            <div class="content-block sidebar-block company-info">
                <div style="text-align:center; margin-bottom: 15px;">
                    @if(optional($job->company)->logo)
                        <img src="{{ asset('storage/' . $job->company->logo) }}"
                             alt="Logo" style="width:80px; height:80px; border-radius:10px; object-fit:cover; border:1px solid #eee;">
                    @else
                        <div style="width:80px; height:80px; border-radius:10px; background:linear-gradient(135deg,#00b14f,#005a28); display:flex; align-items:center; justify-content:center; font-size:36px; margin:0 auto; border:2px solid #e0f2f1;">
                            🏢
                        </div>
                    @endif
                </div>
                <h3 style="text-align:center; margin-bottom:12px;">
                    <a href="{{ route('company.show', optional($job->company)->id) }}"
                       style="color:inherit; text-decoration:none; transition:color .2s;"
                       onmouseover="this.style.color='#00b14f'" onmouseout="this.style.color='inherit'">
                        {{ optional($job->company)->name ?? 'Công ty ẩn danh' }}
                    </a>
                </h3>
                <div class="info-item"><strong>Mã số thuế:</strong> {{ optional($job->company)->tax_code }}</div>
                <div class="info-item"><strong>Email:</strong> {{ optional($job->company)->email }}</div>
                <div class="info-item"><strong>Hotline:</strong> {{ optional($job->company)->hotline }}</div>
                <div class="info-item"><strong>Địa điểm:</strong> {{ optional($job->company)->address }}</div>
                @if(optional($job->company)->id)
                    <a href="{{ route('company.show', $job->company->id) }}"
                       style="display:block; text-align:center; margin-top:16px; padding:10px 16px;
                              background:linear-gradient(135deg,#00b14f,#00913f); color:#fff;
                              border-radius:8px; font-size:13px; font-weight:700;
                              text-decoration:none; transition:all .2s;
                              box-shadow:0 3px 10px rgba(0,177,79,.25);"
                       onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 5px 16px rgba(0,177,79,.35)'"
                       onmouseout="this.style.transform=''; this.style.boxShadow='0 3px 10px rgba(0,177,79,.25)'">
                        🏢 Xem trang công ty
                    </a>
                @endif
            </div>

            <div class="content-block sidebar-block similar-jobs">
                <h3>Việc làm tương tự</h3>
                <ul>
                    @forelse($similarJobs as $sJob)
                        <li>
                            <a href="{{ url('/job/' . $sJob->id) }}">{{ $sJob->title }}</a>
                            <span class="company">{{ optional($sJob->company)->name }}</span>
                        </li>
                    @empty
                        <li style="border: none; color: #777;">Chưa có việc làm tương tự.</li>
                    @endforelse
                </ul>
            </div>
        </aside>
    </div>

    @auth
    <!-- Modal Ứng tuyển -->
    <div id="applyModal" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
        <div class="modal-content" style="background: white; width: 90%; max-width: 500px; margin: 100px auto; border-radius: 8px; padding: 25px; position: relative; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
            <span onclick="document.getElementById('applyModal').style.display='none'" style="position: absolute; right: 20px; top: 15px; font-size: 24px; cursor: pointer; color: #888;">&times;</span>
            <h2 style="margin-top: 0; font-size: 20px; color: var(--primary);">Ứng tuyển công việc</h2>
            <p style="color: #555; margin-bottom: 20px;"><strong>{{ $job->title }}</strong></p>
            
            <form action="{{ route('job.apply', $job->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px;">Tải lên CV (Bắt buộc) <span style="color: red;">*</span></label>
                    <input type="file" name="cv_file" accept=".pdf,.doc,.docx" required style="width: 100%; box-sizing:border-box; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    <small style="color: #888; display: block; margin-top: 5px;">Chấp nhận định dạng .pdf, .doc, .docx (tối đa 5MB)</small>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px;">Thư giới thiệu (Không bắt buộc)</label>
                    <textarea name="cover_letter" rows="4" placeholder="Viết vài dòng giới thiệu về bản thân và lý do bạn phù hợp với vị trí này..." style="width: 100%; box-sizing:border-box; padding: 10px; border: 1px solid #ddd; border-radius: 5px; resize: vertical;"></textarea>
                </div>
                <div style="text-align: right;">
                    <button type="button" onclick="document.getElementById('applyModal').style.display='none'" class="btn btn-outline" style="margin-right: 10px;">Hủy</button>
                    <button type="submit" class="btn btn-primary">Gửi hồ sơ</button>
                </div>
            </form>
        </div>
    </div>
    @endauth
@endsection