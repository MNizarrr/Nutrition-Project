<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up to NutriTrack</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.min.css" rel="stylesheet" />
</head>

<body>
    <form class="w-50 d-block mx-auto my-5" method="POST">
        @if (Session::get('failed'))
            <div class="alert alert-danger my-3">{{ Session::get('failed', 'Gagal memperoleh data! Silahkan coba lagi!') }}
            </div>
        @endif
        @csrf
        <div class="row mb-4">
            <div class="col">
                @error('first_name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                <div data-mdb-input-init class="form-outline">
                    <input type="text" id="form3Example1" class="form-control @error('first_name') is-invalid @enderror"
                        name="first_name" />
                    <label class="form-label" for="form3Example1">First name</label>
                </div>
            </div>
            <div class="col">
                @error('last_name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                <div data-mdb-input-init class="form-outline">
                    <input type="text" id="form3Example2" class="form-control @error('last_name') is-invalid @enderror"
                        name="last_name" />
                    <label class="form-label" for="form3Example2">Last name</label>
                </div>
            </div>
        </div>

        <!-- Gender input -->
        <div class="form-outline mb-4">
            @error('gender')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            <select name="gender" id="type" class="form-select @error('gender') is-invalid @enderror">
                <option value="">Pilih Jenis Kelamin</option>
                <option value="L">Laki Laki</option>
                <option value="P">perempuan </option>
            </select>
        </div>

        <!-- Email input -->
        @error('email')
            <small class="text-danger">{{ $message }}</small>
        @enderror
        <div data-mdb-input-init class="form-outline mb-4">
            <input type="email" id="form3Example3" class="form-control @error('email') is-invalid @enderror"
                name="email" />
            <label class="form-label" for="form3Example3">Email address</label>
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <label for="date_of_birth" class="form-label">Tanggal Lahir</label>
                <input type="date" name="date_of_birth" id="date_of_birth" class="form-control @error('date_of_birth') is-invalid
                @enderror">
                @error('date_of_birth')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-6">
                <label for="profile_image" class="form-label">Foto Profil</label>
                <input type="file" name="profile_image" id="profile_image" class="form-control @error('profile_image')
                is-invalid @enderror">
                @error('profile_image')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <!-- Password input -->
        @error('password')
            <small class="text-danger">{{ $message }}</small>
        @enderror
        <div data-mdb-input-init class="form-outline mb-4">
            <input type="password" id="form3Example4" class="form-control @error('password') is-invalid @enderror"
                name="password" />
            <label class="form-label" for="form3Example4">Password</label>
        </div>

        <!-- Checkbox -->
        <div class="form-check justify-content-center mb-4 ms-3">
            <input class="form-check-input me-2" type="checkbox" value="" id="form2Example33" checked />
            <label class="form-check-label" for="form2Example33">
                Ingat saya
            </label>
        </div>

        <!-- Submit button -->
        <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block mb-4">Sign In</button>
        <div class="text-center mt-3">
            <a href="{{ route('home') }}">Kembali</a>
        </div>
    </form>
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.umd.min.js">
    </script>
</body>

</html>
