@extends('templates.app')

@section('content')
<div class="container mt-5">
    <h2>Hasil Perthitungan IMT</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Tinggi (m)</th>
                    <th>Berat (kg)</th>
                    <th>IMT</th>
                    <th>Kategori</th>
                    <th>Guru Cek</th>
                    <th>Umpan Balik</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $record)
                    <tr>
                        <td>{{ $record->record_date }}</td>
                        <td>{{ $record->height }}</td>
                        <td>{{ $record->weight }}</td>
                        <td>{{ $record->bmi_value }}</td>
                        <td>{{ $record->bmi_category }}</td>
                        <td>
                            @if($record->teacher_checked)
                                <i class="fas fa-check text-success"></i>
                            @else
                                <i class="fas fa-times text-danger"></i>
                            @endif
                        </td>
                        <td>
                            @if($record->admin_status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($record->admin_status == 'approved')
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
