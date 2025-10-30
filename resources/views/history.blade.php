@extends('templates.app')

@section('content')
<div class="container mt-5">
    <h2>BMI History</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Height (m)</th>
                    <th>Weight (kg)</th>
                    <th>BMI</th>
                    <th>Category</th>
                    <th>Teacher Checked</th>
                    <th>Admin Status</th>
                    <th>Admin Message</th>
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
                        <td>{{ $record->admin_message ?: '-' }}</td>
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
