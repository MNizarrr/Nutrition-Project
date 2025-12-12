@extends('templates.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Kelola Aktivitas Fisik</h2>
                <a href="{{ route('teacher.exercise.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Aktivitas
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
                                    <th>Foto Olahraga</th>
                                    <th>Kalori Terbakar (per jam)</th>
                                    <th>Tingkat Intensitas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($activities as $activity)
                                    <tr>
                                        <td>{{ $activity->name }}</td>
                                        <td>{{ Str::limit($activity->description, 50) }}</td>
                                        <td>
                                            <img src="{{ asset('storage/' . $activity->exercise_image) }}" class="card-img-top" alt="{{ $activity->name }}" style="height:50px; object-fit:cover;">
                                        </td>
                                        <td>{{ $activity->calories_burned }} kalori</td>
                                        <td>
                                            <span class="badge bg-{{ $activity->intensity_level == 'Rendah' ? 'success' : ($activity->intensity_level == 'Sedang' ? 'warning' : 'danger') }}">
                                                {{ $activity->intensity_level }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $activity->status == 'active' ? 'success' : 'secondary' }}">
                                                {{ $activity->status == 'active' ? 'Aktif' : 'Non-Aktif' }}
                                            </span>
                                        </td>
                                        <td>
                                            <form action="{{ route('teacher.exercise.toggle', $activity) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm {{ $activity->status == 'active' ? 'btn-warning' : 'btn-success' }}">
                                                    <i class="{{ $activity->status == 'active' ? 'fas fa-ban' : 'fas fa-check' }}"></i> {{ $activity->status == 'active' ? 'Non-Aktif' : 'Aktifkan' }}
                                                </button>
                                            </form>
                                            <a href="{{ route('teacher.exercise.edit', $activity) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('teacher.exercise.destroy', $activity) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus aktivitas ini?')">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada aktivitas fisik yang ditambahkan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('teacher.exercise.trash') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-trash"></i> Lihat Sampah
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
