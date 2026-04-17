@extends('layouts.master')

@section('title', 'Việc làm đã ứng tuyển | MyJobCV')

@section('content')
    <div class="container account-grid">
        @include('partials.account-sidebar', ['active' => 'applied_jobs'])

        <main class="account-content">
            <h1 class="account-content-title">Việc làm đã ứng tuyển</h1>

            @if(session('success'))
                <div class="alert alert-success" style="background: #e6f4ea; color: #1e7e34; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                    {{ session('success') }}
                </div>
            @endif

            <style>
            .applied-job-card {
                background: #ffffff;
                border: 1px solid #edf2f7;
                border-radius: 12px;
                padding: 24px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
                overflow: hidden;
            }

            .applied-job-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 12px 20px rgba(0, 0, 0, 0.06);
                border-color: #cbd5e1;
            }

            .applied-job-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 4px;
                height: 100%;
                background: transparent;
                transition: background 0.3s;
            }

            .applied-job-card:hover::before {
                background: #00b14f;
            }

            .job-header-flex { display: flex; justify-content: space-between; align-items: flex-start; }
            
            .job-company-logo {
                width: 64px; height: 64px; object-fit: cover; border-radius: 10px;
                margin-right: 20px; border: 1px solid #e2e8f0; box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            }

            .job-main-info { flex: 1; }
            .job-title-link {
                font-size: 18px; font-weight: 700; color: #1e293b;
                text-decoration: none; transition: color 0.2s; line-height: 1.3;
                display: block; margin-bottom: 6px;
            }
            .job-title-link:hover { color: #00b14f; }
            .job-company-name { font-size: 14px; color: #64748b; margin: 0 0 12px; font-weight: 500; }
            
            .job-meta-flex { display: flex; flex-wrap: wrap; gap: 12px; font-size: 13px; color: #64748b; }
            .job-meta-item {
                display: inline-flex; align-items: center; background: #f8fafc;
                padding: 4px 10px; border-radius: 6px; border: 1px solid #f1f5f9;
            }

            .job-actions-block { display: flex; flex-direction: column; align-items: flex-end; gap: 12px; }
            .job-status-badge {
                display: inline-flex; align-items: center; padding: 6px 14px; border-radius: 20px;
                font-size: 12px; font-weight: 700; letter-spacing: 0.3px; text-transform: uppercase;
                box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            }
            .status-pending { background: #fffbeb; color: #d97706; border: 1px solid #fef3c7; }
            .status-reviewed { background: #f0f9ff; color: #0284c7; border: 1px solid #e0f2fe; }
            .status-accepted { background: #f0fdf4; color: #16a34a; border: 1px solid #dcfce7; }
            .status-rejected { background: #fef2f2; color: #dc2626; border: 1px solid #fee2e2; }

            .btn-toggle-details {
                padding: 8px 16px; font-size: 13px; font-weight: 600; background: #f8fafc;
                color: #334155; border: 1px solid #e2e8f0; cursor: pointer;
                border-radius: 8px; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px;
            }
            .btn-toggle-details:hover { background: #f1f5f9; border-color: #cbd5e1; color: #0f172a; }

            .application-details-panel {
                display: none; margin-top: 24px; padding-top: 24px;
                border-top: 1px dashed #e2e8f0; animation: fadeInDown 0.3s ease-out forwards;
            }

            @keyframes fadeInDown {
                from { opacity: 0; transform: translateY(-10px); }
                to { opacity: 1; transform: translateY(0); }
            }

            .details-panel-title { margin: 0 0 16px; font-size: 15px; color: #1e293b; font-weight: 700; }
            .details-box { background: #f8fafc; padding: 20px; border-radius: 10px; border: 1px solid #e2e8f0; }
            .cv-attachment-row { margin-bottom: 16px; display: flex; align-items: center; }
            .detail-label {
                min-width: 140px; font-size: 13px; color: #64748b; font-weight: 600;
                text-transform: uppercase; letter-spacing: 0.5px;
            }
            .btn-download-cv {
                display: inline-flex; align-items: center; padding: 8px 18px;
                background: #ecfdf5; color: #059669; text-decoration: none; font-weight: 600;
                border-radius: 8px; font-size: 13px; transition: all 0.2s; border: 1px solid #d1fae5;
            }
            .btn-download-cv:hover { background: #d1fae5; color: #047857; transform: translateY(-1px); }
            .cover-letter-row { display: flex; align-items: flex-start; }
            .cover-letter-text {
                margin: 0; color: #334155; white-space: pre-wrap; font-size: 14px; background: #ffffff;
                padding: 16px; border: 1px solid #e2e8f0; border-radius: 8px; flex: 1;
                line-height: 1.6; box-shadow: inset 0 2px 4px rgba(0,0,0,0.01);
            }
            </style>

            <div class="content-block" style="background: transparent; border: none; padding: 0; box-shadow: none;">
                @if($applications->isEmpty())
                    <div style="text-align: center; padding: 60px 20px; background: #fff; border-radius: 12px; border: 1px solid #edf2f7; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                        <span style="font-size: 48px; display: block; margin-bottom: 16px;">📄</span>
                        <h3 style="margin-top: 15px; color: #1e293b; font-weight: 700;">Bạn chưa ứng tuyển công việc nào!</h3>
                        <p style="color: #64748b; margin-bottom: 24px; font-size: 15px;">Cơ hội nghề nghiệp tuyệt vời đang chờ bạn phía trước. Hãy bắt đầu hành trình của mình!</p>
                        <a href="{{ url('/') }}" class="btn btn-primary" style="border-radius: 30px; padding: 12px 30px; font-weight: 600;">Khám phá việc làm ngay</a>
                    </div>
                @else
                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        @foreach($applications as $application)
                            @php
                                $job = $application->job;
                                $statusClass = 'status-pending';
                                $statusText = 'Đang chờ duyệt';
                                if($application->status == 'reviewed') { $statusClass = 'status-reviewed'; $statusText = 'Đã xem hồ sơ'; }
                                elseif($application->status == 'accepted') { $statusClass = 'status-accepted'; $statusText = 'Trúng tuyển'; }
                                elseif($application->status == 'rejected') { $statusClass = 'status-rejected'; $statusText = 'Từ chối'; }
                            @endphp
                            @if($job)
                            <div class="applied-job-card">
                                <div class="job-header-flex">
                                    <div style="display: flex; align-items: flex-start; flex: 1;">
                                        <img src="{{ optional($job->company)->logo ? Storage::url($job->company->logo) : 'https://via.placeholder.com/64' }}" 
                                             alt="Logo" class="job-company-logo">
                                        
                                        <div class="job-main-info">
                                            <a href="{{ url('/job/' . $job->id) }}" class="job-title-link">
                                                {{ $job->title }}
                                            </a>
                                            <p class="job-company-name">{{ optional($job->company)->name ?? 'Công ty ẩn danh' }}</p>
                                            
                                            <div class="job-meta-flex">
                                                <div class="job-meta-item"><span class="icon">💰</span> {{ $job->salary }}</div>
                                                <div class="job-meta-item"><span class="icon">📍</span> {{ $job->location }}</div>
                                                <div class="job-meta-item" style="background: transparent; border: none;"><span class="icon">🕒</span> Nộp lúc: {{ $application->created_at->format('d/m/Y H:i') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="job-actions-block">
                                        <span class="job-status-badge {{ $statusClass }}">
                                            {{ $statusText }}
                                        </span>
                                        <button onclick="document.getElementById('details-{{ $application->id }}').style.display = document.getElementById('details-{{ $application->id }}').style.display === 'none' ? 'block' : 'none'" class="btn-toggle-details">
                                            Xem hồ sơ đã nộp ▼
                                        </button>
                                    </div>
                                </div>

                                <!-- Phần hiển thị chi tiết hồ sơ -->
                                <div id="details-{{ $application->id }}" class="application-details-panel">
                                    <h4 class="details-panel-title">Chi tiết hồ sơ bạn đã gửi</h4>
                                    <div class="details-box">
                                        <div class="cv-attachment-row">
                                            <div class="detail-label">CV đính kèm</div>
                                            <a href="{{ Storage::url($application->cv_path) }}" target="_blank" class="btn-download-cv">
                                                <span style="font-size: 16px; margin-right: 6px;">📄</span> Xem / Tải xuống bản xem trước CV
                                            </a>
                                        </div>
                                        @if($application->cover_letter)
                                            <div class="cover-letter-row">
                                                <div class="detail-label" style="margin-top: 14px;">Thư tự giới thiệu</div>
                                                <div class="cover-letter-text">{{ $application->cover_letter }}</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </main>
    </div>
@endsection
