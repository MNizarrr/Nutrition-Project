@extends('templates.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Mulai Program Olahraga: {{ $activity->name }}</h3>
                </div>
                <div class="card-body">
                    <p>{{ $activity->description }}</p>
                    <p><strong>Kalori terbakar per jam:</strong> {{ $activity->calories_burned }}</p>
                    <p><strong>Intensitas:</strong> {{ $activity->intensity_level }}</p>

                    <form id="exerciseForm" action="{{ route('user.exercise.finish') }}" method="POST">
                        @csrf
                        <input type="hidden" name="activity_id" value="{{ $activity->id }}">

                        <div class="mb-3">
                            <label for="duration" class="form-label">Durasi Olahraga (menit)</label>
                            <div class="input-group">
                                <button type="button" class="btn btn-outline-secondary" id="decrease">-</button>
                                <input type="number" class="form-control text-center" id="duration" name="duration_minutes" value="30" min="1" readonly>
                                <button type="button" class="btn btn-outline-secondary" id="increase">+</button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Estimasi Kalori Terbakar</label>
                            <div class="alert alert-info">
                                <strong id="calories">0</strong> kalori
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Selesai Olahraga</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const durationInput = document.getElementById('duration');
    const caloriesDisplay = document.getElementById('calories');
    const increaseBtn = document.getElementById('increase');
    const decreaseBtn = document.getElementById('decrease');
    const caloriesPerHour = {{ $activity->calories_burned }};

    function updateCalories() {
        const duration = parseInt(durationInput.value);
        const calories = (caloriesPerHour / 60) * duration;
        caloriesDisplay.textContent = Math.round(calories);
    }

    increaseBtn.addEventListener('click', function() {
        let value = parseInt(durationInput.value);
        durationInput.value = value + 1;
        updateCalories();
    });

    decreaseBtn.addEventListener('click', function() {
        let value = parseInt(durationInput.value);
        if (value > 1) {
            durationInput.value = value - 1;
            updateCalories();
        }
    });

    // Initial calculation
    updateCalories();
});
</script>
@endpush
@endsection
