@extends('templates.app')

@section('content')
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="section-title">Semua Program Olahraga</h2>
                    <p class="text-muted">Pilih program olahraga sesuai kebutuhan Anda</p>
                </div>
            </div>
            <form class="row mb-5" method="GET" action="">
                @csrf
                <div class="col-10">
                    <input type="text" name="search_exercise" value="{{ $search ?? '' }}" placeholder="Cari Progarm Olahraga..." class="form-control">
                </div>
                <div class="col-2">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </form>
            <div class="row mt-3">
                    @forelse($activities as $activity)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                @if(!empty($activity->exercise_image))
                                    <img src="{{ asset('storage/' . $activity->exercise_image) }}" class="card-img-top" alt="{{ $activity->name }}" style="height:180px; object-fit:cover;">
                                @endif
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $activity->name }}</h5>
                                    <p class="card-text flex-grow-1">{{ $activity->description }}</p>
                                    <ul class="list-unstyled mb-3">
                                        <li><i class="fas fa-fire text-primary"></i> Kalori terbakar: {{ $activity->calories_burned }} per jam</li>
                                        <li><i class="fas fa-chart-line text-primary"></i> Intensitas: {{ $activity->intensity_level }}</li>
                                    </ul>
                                    <a href="{{ route('user.exercise.start', $activity->id) }}" class="btn btn-outline-primary mt-auto">Mulai Program</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center">
                                <p class="text-muted">Belum ada program olahraga yang tersedia.</p>
                            </div>
                        </div>
                    @endforelse
            </div>
        </div>
    </div>
@endsection
