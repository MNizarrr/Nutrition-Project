@extends('templates.app')

@section('content')
    <div class="container mt-5">
        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('admin.users.export') }}" class="btn btn-secondary me-2">Export (.Xlsx)</a>
            <a href="{{ route('admin.users.trash') }}" class="btn btn-warning me-2">Data Sampah</a>
            <a href="{{ route('admin.users.create') }}" class="btn btn-success">Tambah Data</a>
        </div>
        <h5 class="mb-3">Data Pengguna</h5>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Jenis Kelamin</th>
                        <th>Tanggal Lahir</th>
                        <th>Foto Profil</th>
                        <th>Role</th>
                        <th>Dibuat Pada</th>
                        <th>Diupdate Pada</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>
                                @if ($item->gender === 'L')
                                    Laki Laki
                                @elseif ($item->gender === 'P')
                                    Perempuan
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $item->date_of_birth ? \Carbon\Carbon::parse($item->date_of_birth)->format('d F Y') : '-' }}</td>
                            <td>
                                @if($item->profile_image)
                                    <img src="{{ asset('storage/' . $item->profile_image) }}" alt="Profile" class="img-thumbnail" style="max-width: 50px; max-height: 50px;">
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if ($item->role->name === 'admin')
                                    <span class="badge bg-primary">Admin</span>
                                @elseif ($item->role->name === 'teacher')
                                    <span class="badge bg-success">Teacher</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($item->role->name) }}</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d F Y H:i') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->updated_at)->format('d F Y H:i') }}</td>
                            <td class="justify-content-center align-items-center gap-2">
                                <a href="{{ route('admin.users.edit', ['id' => $item->id]) }}" class="btn btn-primary btn-sm mb-1"><i class="fa-solid fa-pen"></i></a>
                                <form action="{{ route('admin.users.delete', ['id' => $item->id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
