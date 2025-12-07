{{-- resources/views/home.blade.php --}}
@extends('templates.app') {{-- Asumsi template navbar ada di layouts/app.blade.php --}}

@section('content')
    @if (Session::get('success'))
        {{-- Auth User() mengambil data user yang login --}}
        <div class="alert alert-success my-3">{{session::get('success')}} Selamat datang,<b> {{Auth::user()->name}}</b></div>
        {{-- Auth::user()->name : kata name di ambil dari model user - fillable --}}
    @endif

    @if (Session::get('logout'))
        <div class="alert alert-warning">{{session::get('logout')}}</div>
    @endif
    <div class="container-fluid">
        <!-- Hero Section -->
        <section class="hero-section bg-primary text-white py-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h1 class="display-4 fw-bold mb-3">Selamat Datang di Platform Gizi Sehat</h1>
                        <p class="lead mb-4">Kelola berat badan ideal, hitung Indeks Massa Tubuh (IMT), dan temukan program
                            olahraga yang tepat untuk hidup lebih sehat.</p>
                        <div class="d-flex gap-3 flex-wrap">
                            <a href="{{ route("bmicalculator") }}" class="btn btn-light btn-lg px-4">Hitung IMT Sekarang</a>
                            <a href="#program" class="btn btn-outline-light btn-lg px-4">Lihat Program</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Program Olahraga Section -->
        <section id="program" class="py-5">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center mb-5">
                        <h2 class="section-title">Program Olahraga</h2>
                        <p class="text-muted">Pilih program olahraga sesuai kebutuhan Anda</p>
                    </div>
                </div>

                <a href="" class="btn btn-outline-primary rounded-pill mb-5">Semua Kegiatan</a>

                <div class="row">
                    @forelse($activities as $activity)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
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
        </section>

        <!-- Tips Gizi Section -->
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center mb-5">
                        <h2 class="section-title">Tips Gizi Sehat</h2>
                        <p class="text-muted">Panduan nutrisi untuk hidup lebih sehat</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="text-center">
                            <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 80px; height: 80px;">
                                <i class="fas fa-apple-alt text-white fa-2x"></i>
                            </div>
                            <h5>Makan Seimbang</h5>
                            <p class="text-muted">Konsumsi makanan dengan gizi seimbang dari semua kelompok makanan.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="text-center">
                            <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 80px; height: 80px;">
                                <i class="fas fa-tint text-white fa-2x"></i>
                            </div>
                            <h5>Hidrasi Cukup</h5>
                            <p class="text-muted">Minum 8-10 gelas air per hari untuk menjaga metabolisme tubuh.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="text-center">
                            <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 80px; height: 80px;">
                                <i class="fas fa-utensils text-white fa-2x"></i>
                            </div>
                            <h5>Porsi Tepat</h5>
                            <p class="text-muted">Kontrol porsi makan dengan metode piring sehat untuk asupan optimal.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="text-center">
                            <div class="bg-info rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 80px; height: 80px;">
                                <i class="fas fa-ban text-white fa-2x"></i>
                            </div>
                            <h5>Batasi Gula</h5>
                            <p class="text-muted">Kurangi konsumsi gula tambahan dan makanan olahan untuk kesehatan jangka
                                panjang.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('imtForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const berat = parseFloat(document.getElementById('berat').value);
            const tinggi = parseFloat(document.getElementById('tinggi').value) / 100; // Convert cm to m
            const usia = parseInt(document.getElementById('usia').value);
            const jenisKelamin = document.querySelector('input[name="jenis_kelamin"]:checked').value;

            // Hitung IMT
            const imt = berat / (tinggi * tinggi);
            const imtRounded = imt.toFixed(1);

            // Tentukan status gizi
            let statusGizi, keterangan, progressWidth, progressColor;

            if (imt < 18.5) {
                statusGizi = 'Kurus';
                keterangan = 'Disarankan untuk meningkatkan asupan gizi dan konsultasi dengan ahli gizi.';
                progressWidth = 25;
                progressColor = 'bg-warning';
            } else if (imt >= 18.5 && imt < 25) {
                statusGizi = 'Normal';
                keterangan = 'Pertahankan berat badan ideal dengan pola makan sehat dan olahraga teratur.';
                progressWidth = 50;
                progressColor = 'bg-success';
            } else if (imt >= 25 && imt < 30) {
                statusGizi = 'Gemuk';
                keterangan = 'Disarankan untuk menurunkan berat badan dengan diet sehat dan olahraga.';
                progressWidth = 75;
                progressColor = 'bg-warning';
            } else {
                statusGizi = 'Obesitas';
                keterangan = 'Segera konsultasi dengan dokter atau ahli gizi untuk program penurunan berat badan.';
                progressWidth = 100;
                progressColor = 'bg-danger';
            }

            // Tampilkan hasil
            document.getElementById('nilaiIMT').textContent = imtRounded;
            document.getElementById('statusGizi').textContent = statusGizi;
            document.getElementById('keteranganIMT').textContent = keterangan;

            const progressBar = document.getElementById('progressIMT');
            progressBar.style.width = progressWidth + '%';
            progressBar.className = 'progress-bar ' + progressColor;
            progressBar.textContent = statusGizi;

            document.getElementById('hasilIMT').classList.remove('d-none');
        });
    </script>
@endpush

@push('styles')
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .section-title {
            position: relative;
            padding-bottom: 15px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: #007bff;
        }

        .card {
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .progress {
            background-color: #e9ecef;
            border-radius: 10px;
        }

        .progress-bar {
            border-radius: 10px;
            transition: width 0.6s ease;
        }
    </style>
@endpush
