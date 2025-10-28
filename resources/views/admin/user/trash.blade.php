@extends('templates.app')

@section('content')
    <div class="container mt-5">
        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5>Data Sampah Pengguna</h5>
            <div>
                <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        @if($userTrash->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Dihapus Pada</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
            @foreach ($userTrash as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    @if ($item->role->name === 'admin')
                                        <span class="badge bg-primary">Admin</span>
                                    @elseif ($item->role->name === 'teacher')
                                        <span class="badge bg-success">Teacher</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($item->role->name) }}</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($item->deleted_at)->format('d F Y H:i') }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <form action="{{ route('admin.users.restore', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm"
                                                onclick="return confirm('Apakah Anda yakin ingin memulihkan pengguna ini?')">
                                                <i class="fa-solid fa-recycle"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.users.delete_permanent', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus permanen pengguna ini? Tindakan ini tidak dapat dibatalkan!')">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info text-center">
                <i class="fa-solid fa-trash-can me-2"></i>
                Tidak ada data di sampah.
            </div>
        @endif
    </div>
@endsection
