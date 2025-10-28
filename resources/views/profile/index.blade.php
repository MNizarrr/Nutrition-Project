<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile - NutriTrack</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container">
        @if (Session::has('success'))
            <div class="alert alert-success my-3">{{ Session::get('success') }}</div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger my-3">{{ Session::get('error') }}</div>
        @endif
        <div class="row">
            <div class="col-12 text-center mt-5">
                <h2 class="section-title">Profil Pengguna</h2>
            </div>
        </div>

        <div class="container ms-5 mt-5">
            <div class="row">
                <div class="col-6">

                    <div class="row mb-4">
                        <div class="col-12">
                            <h5>Nama Lengkap</h5>
                            <p>{{ $user->name }}</p>
                        </div>
                    </div>

                    <!-- Gender display -->
                    <div class="mb-4">
                        <h5>Jenis Kelamin</h5>
                        <p>{{ $user->gender == 'L' ? 'Laki Laki' : 'Perempuan' }}</p>
                    </div>

                    <div class="mb-4">
                        <h5>Tanggal Lahir</h5>
                        <p>{{ \Carbon\Carbon::parse($user->date_of_birth)->format('d M Y') }}</p>
                    </div>
                </div>

                <div class="col-6">
                    <h5>Foto Profil</h5>
                    @if($user->profile_image)
                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Foto Profil"
                            class="img-fluid rounded" style="max-width: 150px;">
                    @else
                        <p>Tidak ada foto profil</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="text-center mt-3">
            <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profil</a>
            <a href="{{ route('home') }}" class="btn btn-secondary ml-2">Kembali</a>
            <a href="{{ route(name: 'logout') }}" class="btn btn-danger ml-2 ms-5">LogOut</a>
        </div>
    </div>
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.umd.min.js">
    </script>
</body>

</html>
