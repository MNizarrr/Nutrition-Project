@extends('templates.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Tambah Aktivitas Fisik Baru</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('teacher.exercise.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Aktivitas</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="calories_burned" class="form-label">Kalori Terbakar per Jam</label>
                            <input type="number" step="0.01" class="form-control @error('calories_burned') is-invalid @enderror" id="calories_burned" name="calories_burned" value="{{ old('calories_burned') }}" required>
                            @error('calories_burned')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="intensity_level" class="form-label">Tingkat Intensitas</label>
                            <select class="form-select @error('intensity_level') is-invalid @enderror" id="intensity_level" name="intensity_level" required>
                                <option value="">Pilih Tingkat Intensitas</option>
                                <option value="Rendah" {{ old('intensity_level') == 'Rendah' ? 'selected' : '' }}>Rendah</option>
                                <option value="Sedang" {{ old('intensity_level') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="Tinggi" {{ old('intensity_level') == 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
                            </select>
                            @error('intensity_level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('teacher.exercise.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
