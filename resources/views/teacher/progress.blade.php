@extends('templates.app')

@section('content')
    <div class="container mt-5">
        <h1>Lihat Progress User</h1>
        <div class="table-responsive mt-4">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Alamat Email</th>
                        <th>IMT Terbaru</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Kompeten</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            @if($user->bmiRecords->isNotEmpty())
                                <td>{{ $user->bmiRecords->first()->bmi_value }}</td>
                                <td>{{ $user->bmiRecords->first()->bmi_category }}</td>
                                <td>{{ $user->bmiRecords->first()->record_date }}</td>
                                <td>
                                    @if($user->bmiRecords->first()->teacher_checked)
                                        <i class="fas fa-check text-success"></i>
                                    @else
                                        <i class="fas fa-times text-danger"></i>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('teacher.progress.toggle', $user->bmiRecords->first()->id) }}"
                                        method="POST" style="display: inline;">
                                        @csrf
                                        @method('POST')
                                        {{-- <button type="submit" class="btn btn-sm btn-outline-primary">
                                            @if($user->bmiRecords->first()->teacher_checked)
                                            Tidak Kompeten
                                            @else
                                            Kompeten
                                            @endif
                                        </button> --}}
                                        @if($user->bmiRecords->first()->teacher_checked)
                                            <button type="submit" class="btn btn-sm btn-outline-warning">
                                                Tidak Kompeten
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-sm btn-outline-success">
                                                Kompeten
                                            </button>
                                            @endif
                                    </form>
                                </td>
                            @else
                                <td colspan="5" class="text-center">Tidak ada catatan IMT</td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">tidak ada pengguna yang ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
