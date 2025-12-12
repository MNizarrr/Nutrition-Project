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
                                <input type="number" class="form-control text-center" id="duration" name="duration_minutes" value="30" min="5" readonly>
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

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ambil elemen input durasi, tampilan kalori, dan tombol + / -
    const durationInput = document.getElementById('duration');
    const caloriesDisplay = document.getElementById('calories');
    const increaseBtn = document.getElementById('increase');
    const decreaseBtn = document.getElementById('decrease');

    // Nilai kalori yang dibakar per jam, berasal dari database (Laravel blade)
    const caloriesPerHour = {{ $activity->calories_burned }};

    // Fungsi untuk menghitung total kalori berdasarkan durasi (menit)
    function updateCalories() {
        const duration = parseInt(durationInput.value); // ambil nilai durasi
        const calories = (caloriesPerHour / 60) * duration; // rumus: kalori per menit * durasi
        caloriesDisplay.textContent = Math.round(calories); // tampilkan hasil, dibulatkan
    }

    // Tombol untuk menambah durasi +5 menit
    increaseBtn.addEventListener('click', function() {
        let value = parseInt(durationInput.value);
        durationInput.value = value + 5; // tambah 5 menit
        updateCalories(); // hitung ulang kalori
    });

    // Tombol untuk mengurangi durasi -5 menit, minimal tidak boleh kurang dari 1
    decreaseBtn.addEventListener('click', function() {
        let value = parseInt(durationInput.value);
        if (value > 1) {
            durationInput.value = value - 5; // kurangi 5 menit
            updateCalories();
        }
    });

    updateCalories(); // Hitung kalori pertama kali saat halaman dimuat
}); 
</script>
@endpush
