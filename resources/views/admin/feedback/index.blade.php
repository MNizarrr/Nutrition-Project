@extends('templates.app')

@section('content')
<div class="container mt-5">
    <h2>BMI Feedback Management</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Date</th>
                    <th>Height (m)</th>
                    <th>Weight (kg)</th>
                    <th>BMI</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Message</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $record)
                    <tr>
                        <td>{{ $record->user->name ?? 'N/A' }}</td>
                        <td>{{ $record->record_date->format('Y-m-d') }}</td>
                        <td>{{ $record->height }}</td>
                        <td>{{ $record->weight }}</td>
                        <td>{{ $record->bmi_value }}</td>
                        <td>{{ $record->bmi_category }}</td>
                        <td>
                            <form action="{{ route('admin.feedback.update', $record) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <select name="admin_status" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="pending" {{ $record->admin_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $record->admin_status == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ $record->admin_status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('admin.feedback.update', $record) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <textarea name="admin_message" class="form-control form-control-sm" rows="2" placeholder="Enter message">{{ $record->admin_message }}</textarea>
                                <button type="submit" class="btn btn-sm btn-primary mt-1">Update</button>
                            </form>
                        </td>
                        <td>
                            <!-- Actions if needed -->
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
