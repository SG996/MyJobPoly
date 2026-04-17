@extends('layouts.master')

@section('title', 'Việc làm đã lưu | MyJobCV')

@section('content')
    <div class="container account-grid">

        @include('partials.account-sidebar', ['active' => 'saved_jobs'])

        <main class="account-content">
            <h1 class="account-content-title">Việc làm đã lưu</h1>
            <p class="account-content-subtitle">Xem lại danh sách các công việc bạn đã yêu thích và đánh dấu</p>

            @if(session('success'))
                <div style="color: #155724; background-color: #d4edda; padding: 12px; border-radius: 5px; margin-bottom: 20px; font-weight: 500;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-top: 20px;">
                @forelse($jobs as $job)
                    <div style="border: 1px solid var(--border-color); border-radius: 8px; padding: 15px; position: relative; background: white; transition: 0.3s;" onmouseover="this.style.borderColor='var(--primary)';" onmouseout="this.style.borderColor='var(--border-color)';">

                        <form action="{{ route('job.save', $job->id) }}" method="POST" style="position: absolute; top: 15px; right: 15px;">
                            @csrf
                            <button type="submit" title="Bỏ lưu" style="background: none; border: none; font-size: 20px; color: #dc3545; cursor: pointer;">❤️</button>
                        </form>

                        <a href="{{ url('/job/' . $job->id) }}" style="text-decoration: none; color: inherit;">
                            <div style="display: flex; gap: 15px; align-items: flex-start;">
                                <img src="{{ optional($job->company)->logo ? Storage::url($job->company->logo) : 'https://via.placeholder.com/60' }}" alt="Logo" style="width: 50px; height: 50px; border-radius: 5px; object-fit: contain; border: 1px solid #eee;">
                                <div>
                                    <h3 style="font-size: 15px; margin: 0 0 5px 0; color: var(--dark); padding-right: 25px; line-height: 1.4;">{{ $job->title }}</h3>
                                    <p style="font-size: 13px; color: var(--text-muted); margin: 0 0 10px 0;">{{ optional($job->company)->name ?? 'Công ty ẩn danh' }}</p>

                                    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                        <span style="background: #f1fef6; color: var(--primary); padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 600;">{{ $job->salary }}</span>
                                        <span style="background: #f5f5f5; color: #555; padding: 4px 10px; border-radius: 4px; font-size: 12px;">{{ $job->location }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div style="grid-column: span 2; text-align: center; padding: 50px; background: #fafafa; border-radius: 8px;">
                        <span style="font-size: 40px;">📭</span>
                        <h3 style="margin-top: 15px; color: var(--dark);">Bạn chưa lưu công việc nào!</h3>
                        <p style="color: var(--text-muted); margin-bottom: 20px;">Hãy lướt tìm và thả tim những công việc bạn ưng ý nhé.</p>
                        <a href="{{ url('/') }}" class="btn btn-primary">Tìm việc làm ngay</a>
                    </div>
                @endforelse
            </div>
        </main>

    </div>
@endsection 