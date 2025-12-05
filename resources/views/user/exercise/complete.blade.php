@extends('templates.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3>Selamat! Olahraga Selesai</h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>

                    <h4>Ringkasan Sesi Olahraga</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Aktivitas:</strong> {{ $session->physicalActivity->name }}</p>
                            <p><strong>Durasi:</strong> {{ $session->duration_minutes }} menit</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Kalori Terbakar:</strong> {{ $session->calories_burned }} kalori</p>
                            <p><strong>Waktu Selesai:</strong> {{ $session->finished_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('user.exercise.pdf', $session->id) }}" class="btn btn-primary">
                            <i class="fas fa-download"></i> Download PDF
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-secondary">
                            <i class="fas fa-home"></i> Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
