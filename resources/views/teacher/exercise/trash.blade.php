@extends('templates.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Sampah Aktivitas Fisik</h2>
                <a href="{{ route('teacher.exercise.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            @if (Session::get('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Aktivitas</th>
                                    <th>Deskripsi</th>
                                    <th>Kalori Terbakar (per jam)</th>
                                    <th>Tingkat Intensitas</th>
                                    <th>Dihapus Pada</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($trashedActivities as $activity)
                                    <tr>
                                        <td>{{ $activity->name }}</td>
                                        <td>{{ Str::limit($activity->description, 50) }}</td>
                                        <td>{{ $activity->calories_burned }} kalori</td>
                                        <td>
                                            <span class="badge bg-{{ $activity->intensity_level == 'Rendah' ? 'success' : ($activity->intensity_level == 'Sedang' ? 'warning' : 'danger') }}">
                                                {{ $activity->intensity_level }}
                                            </span>
                                        </td>
                                        <td>{{ $activity->deleted_at->format('d M Y H:i') }}</td>
                                        <td>
                                            <form action="{{ route('teacher.exercise.restore', $activity) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="fas fa-undo"></i> Restore
                                                </button>
                                            </form>
                                            <form action="{{ route('teacher.exercise.force-delete', $activity) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus permanen aktivitas ini?')">
                                                    <i class="fas fa-times"></i> Hapus Permanen
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada aktivitas fisik di sampah.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
