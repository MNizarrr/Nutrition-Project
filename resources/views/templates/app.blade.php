<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GiziFit Web</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />

    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />

    <!-- PLACEHOLDER UNTUK STYLE TAMBAHAN -->
    @stack('style')
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
        <!-- Container wrapper -->
        <div class="container-fluid">
            <!-- Toggle button -->
            <button data-mdb-collapse-init class="navbar-toggler" type="button"
                data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Collapsible wrapper -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Navbar brand -->
                <a class="navbar-brand mt-2 mt-lg-0" href="/">
                    <i class="fa-solid fa-star-of-life" style="font-size: 25px"></i>
                    <h5 class="mt-2 ms-1 me-2" style="font-size: 30px">
                        Gizifit
                    </h5>
                </a>
                <!-- Left links -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @if (Auth::check() && Auth::user()->role->name == 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">Dasbor</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.users.index') }}">Kelola Users</a>
                        </li>
                    @elseif (Auth::check() && Auth::user()->role->name == 'teacher')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('teacher.dashboard') }}">Dasbor</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('teacher.progress') }}">Lihat Progress User</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('teacher.exercise.index') }}">Kelola Aktivitas Fisik</a>
                        </li>

                    @elseif (Auth::check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('bmicalculator') }}">Hitung IMT</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('history') }}">Sejarah Hasil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('physical.activity') }}">Aktivitas Fisik</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('signin') }}">Hitung IMT</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('signin') }}">Sejarah Hasil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('signin') }}">Aktivitas Fisik</a>
                        </li>
                    @endif
                </ul>
                <!-- Left links -->
            </div>
            <!-- Collapsible wrapper -->

            <!-- Right elements -->

            <div class="d-flex align-items-center">
                {{-- Auth::check : mengecek sudah login atau belum --}}
                @if (Auth::check())
                    <div class="dropdown">
                        <a data-mdb-dropdown-init class="dropdown-toggle d-flex align-items-center hidden-arrow" href="#"
                            id="navbarDropdownMenuAvatar" role="button" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <small class="me-2">
                                    {{ Auth::user()->name }}
                                </small>
                                <!-- Avatar -->
                                @auth
                                    <img src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : asset('images/default-avatar.png') }}"
                                        class="rounded-circle" height="35" alt="Profile Picture" loading="lazy" />
                                @endauth
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.index') }}">Profil Saya</a>
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route(name: 'logout') }}">Keluar</a>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('signin') }}" class="btn btn-link text-warning px-3 me-2">
                        Masuk
                    </a>
                    <a href="{{ route('signup') }}" class="btn btn-primary me-3">
                        Registrasi Gratis
                    </a>
                @endif
            </div>
        </div>
        <!-- Right elements -->
        </div>
        <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->

    {{-- wadah content dinamis --}}
    <div style="padding-top: 70px;">
        @yield('content')
    </div>

    <!-- jQuery (WAJIB MASUK DULU, TAPI CUKUP SATU!) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"
        crossorigin="anonymous"></script>

    <!-- MDB -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.umd.min.js"></script>

    <!-- ========================= -->
    <!--       DATATABLES JS      -->
    <!-- ========================= -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    {{-- Script tambahan --}}
    @stack('script')

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>

</html>
