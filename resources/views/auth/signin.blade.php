@extends('templates.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-center mb-4">Sign In to NutriTrack</h5>
                        <form method="POST" action="{{ route('signin.process') }}">
                            @csrf
                            @if (Session::get('success'))
                                <div class="alert alert-success my-3">{{ Session::get('success') }}</div>
                            @endif
                            @if (Session::get('error'))
                                <div class="alert alert-danger my-3">{{ Session::get('error') }}</div>
                            @endif

                            <!-- Email input -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="email" name="email" id="form1Example1" class="form-control" />
                                <label class="form-label" for="form1Example1">Email Address</label>
                            </div>

                            <!-- Password input -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="password" name="password" id="form1Example2" class="form-control" />
                                <label class="form-label" for="form1Example2">Password</label>
                            </div>

                            <!-- Checkbox -->
                            <div class="form-check justify-content-center mb-4 ms-3">
                                <input class="form-check-input" type="checkbox" value="" id="form1Example3" checked />
                                <label class="form-check-label" for="form1Example3">Ingat Saya</label>
                            </div>

                            <div class="d-grid">
                                <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block">Sign In</button>
                            </div>

                            <div class="text-center mt-3">
                                <a href="{{ route('home') }}">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
