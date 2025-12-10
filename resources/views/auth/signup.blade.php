@extends('templates.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-center mb-4">Daftar Ke GiziFit</h5>
                        <form method="POST" action="{{ route('signup') }}" enctype="multipart/form-data">
                            @if (Session::has('success'))
                                <div class="alert alert-success my-3">{{ Session::get('success') }}</div>
                            @endif
                            @if (Session::has('error'))
                                <div class="alert alert-danger my-3">{{ Session::get('error') }}</div>
                            @endif

                            @csrf
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    @error('first_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="text" id="form3Example1" class="form-control @error('first_name') is-invalid @enderror"
                                            name="first_name" value="{{ old('first_name') }}" />
                                        <label class="form-label" for="form3Example1">Nama Depan</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    @error('last_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="text" id="form3Example2" class="form-control @error('last_name') is-invalid @enderror"
                                            name="last_name" value="{{ old('last_name') }}" />
                                        <label class="form-label" for="form3Example2">Nama Belakng</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Gender input -->
                            <div class="mb-4">
                                @error('gender')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <label class="form-label" for="gender">Jenis Kelamin</label>
                                <select name="gender" id="gender" class="form-select @error('gender') is-invalid @enderror">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki Laki</option>
                                    <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>

                            <!-- Email input -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <input type="email" id="form3Example3" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" />
                                <label class="form-label" for="form3Example3">Alamat Email</label>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="date_of_birth" class="form-label">Tanggal Lahir</label>
                                    <input type="date" name="date_of_birth" id="date_of_birth"
                                        class="form-control @error('date_of_birth') is-invalid @enderror"
                                        value="{{ old('date_of_birth') }}">
                                    <small class="form-text text-muted">
                                        Gunakan format MM-DD-YYYY
                                    </small>
                                    @error('date_of_birth')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="profile_image" class="form-label">Foto Profil (Opsional)</label>
                                    <input type="file" name="profile_image" id="profile_image"
                                        class="form-control @error('profile_image') is-invalid @enderror"
                                        accept="image/jpeg,image/png,image/jpg,image/webp">
                                    @error('profile_image')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Format: JPG, JPEG, PNG, WEBP. Maksimal: 2MB
                                    </small>
                                </div>
                            </div>

                            <!-- Password input -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <input type="password" id="form3Example4" class="form-control @error('password') is-invalid @enderror"
                                    name="password" />
                                <label class="form-label" for="form3Example4">Kata Sandi</label>
                            </div>

                            <!-- Checkbox -->
                            <div class="form-check justify-content-center mb-4 ms-3">
                                <input class="form-check-input me-2" type="checkbox" value="" id="form2Example33" checked />
                                <label class="form-check-label" for="form2Example33">
                                    Ingat saya
                                </label>
                            </div>

                            <div class="d-grid">
                                <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block">Register</button>
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
