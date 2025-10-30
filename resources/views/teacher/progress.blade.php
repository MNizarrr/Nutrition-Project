@extends('templates.app')

@section('content')
<div class="container mt-5">
    <h1>Lihat Progress User</h1>
    <div class="table-responsive mt-4">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Latest BMI</th>
                    <th>Category</th>
                    <th>Record Date</th>
                    <th>Checked</th>
                    <th>Action</th>
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
                                <form action="{{ route('teacher.progress.toggle', $user->bmiRecords->first()->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-sm btn-outline-primary">
                                        @if($user->bmiRecords->first()->teacher_checked)
                                            Uncheck
                                        @else
                                            Check
                                        @endif
                                    </button>
                                </form>
                            </td>
                        @else
                            <td colspan="5" class="text-center">No BMI records</td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
