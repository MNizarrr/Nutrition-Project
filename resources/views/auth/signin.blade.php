<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign In to NutriTrack</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.min.css" rel="stylesheet" />
</head>

<body>
    <form class="w-50 d-block mx-auto my-5" method="POST" action="{{ route('signin.process') }}">
        @csrf
        @if (Session::get('success'))
            {{-- Session hurufnya di awali dengan huruf besar karena dia sebuah class yang di sambungkan dengan Static di
            sambungkan dengan :: --}}
            <div class="alert alert-success my-3">{{ Session::get('success') }}
            </div>
        @endif
        @if (Session::get('error'))
            <div class="alert alert-danger">{{ Session::get('error')}}</div>
        @endif
        <!-- Email input -->
        <div data-mdb-input-init class="form-outline mb-4">
            <input type="email" name="email" id="form1Example1" class="form-control" />
            <label class="form-label" for="form1Example1">Email address</label>
        </div>

        <!-- Password input -->
        <div data-mdb-input-init class="form-outline mb-4">
            <input type="password" name="password" id="form1Example2" class="form-control" />
            <label class="form-label" for="form1Example2">Password</label>
        </div>

        <!-- 2 column grid layout for inline styling -->
        <div class="row mb-4">
            <div class="col justify-content-center ms-3">
                <!-- Checkbox -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="form1Example3" checked />
                    <label class="form-check-label" for="form1Example3">Ingat Saya</label>
                </div>
            </div>
        </div>

        <!-- Submit button -->
        <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block">Signin</button>
        <div class="text-center mt-3">
            <a href="{{ route('home') }}">Kembali</a>
        </div>
    </form>
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.umd.min.js">
    </script>
</body>

</html>
