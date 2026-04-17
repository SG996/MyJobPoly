@extends('admin.layouts.app')

@section('title', 'Quản lý Đơn Ứng Tuyển')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Danh sách đơn ứng tuyển</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ứng viên</th>
                            <th>Công việc</th>
                            <th>Ngày nộp</th>
                            <th>CV (Tệp)</th>
                            <th>Thư giới thiệu</th>
                            <th>Trạng thái</th>
                            <th>Hành động (Duyệt)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications as $app)
                            <tr>
                                <td>{{ $app->id }}</td>
                                <td>
                                    <strong>{{ optional($app->user)->name }}</strong><br>
                                    <small>{{ optional($app->user)->email }}</small>
                                </td>
                                <td>
                                    <a href="{{ url('/job/' . $app->job_id) }}" target="_blank">{{ optional($app->job)->title }}</a><br>
                                    <small class="text-muted">{{ optional(optional($app->job)->company)->name }}</small>
                                </td>
                                <td>{{ $app->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ Storage::url($app->cv_path) }}" target="_blank" class="btn btn-sm btn-info">Xem CV</a>
                                </td>
                                <td>
                                    @if($app->cover_letter)
                                        <button type="button" class="btn btn-sm btn-secondary" onclick="alert('{{ addslashes($app->cover_letter) }}')">Đọc thư</button>
                                    @else
                                        <span class="text-muted">Không có</span>
                                    @endif
                                </td>
                                <td>
                                    @if($app->status == 'pending') <span class="badge bg-warning">Chờ duyệt</span>
                                    @elseif($app->status == 'reviewed') <span class="badge bg-primary">Đã xem</span>
                                    @elseif($app->status == 'accepted') <span class="badge bg-success">Trúng tuyển</span>
                                    @elseif($app->status == 'rejected') <span class="badge bg-danger">Từ chối</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('admin.applications.update_status', $app->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <select name="status" class="form-control form-control-sm" style="display:inline-block; width:auto;" onchange="this.form.submit()">
                                            <option value="pending" {{ $app->status == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                                            <option value="reviewed" {{ $app->status == 'reviewed' ? 'selected' : '' }}>Đã xem</option>
                                            <option value="accepted" {{ $app->status == 'accepted' ? 'selected' : '' }}>Trúng tuyển</option>
                                            <option value="rejected" {{ $app->status == 'rejected' ? 'selected' : '' }}>Từ chối</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Chưa có đơn ứng tuyển nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{ $applications->links() }}
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection
