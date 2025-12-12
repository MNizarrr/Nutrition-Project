@extends('templates.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">IMT Kalkulator</h3>
                </div>
                <div class="card-body">
                    <form id="bmiForm">
                        @csrf
                        <div class="mb-3">
                            <label for="height" class="form-label">Tinggi Badan (cm)</label>
                            <input type="number" step="0.01" class="form-control" id="height" name="height" required>
                        </div>
                        <div class="mb-3">
                            <label for="weight" class="form-label">Berat Badan (kg)</label>
                            <input type="number" step="0.1" class="form-control" id="weight" name="weight" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Hitung IMT</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- BMI Result Modal -->
<div class="modal fade" id="bmiModal" tabindex="-1" aria-labelledby="bmiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bmiModalLabel">Hasil BMI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Tinggi Badan:</strong> <span id="modalHeight"></span> cm</p>
                <p><strong>Berat Badan:</strong> <span id="modalWeight"></span> kg</p>
                <p><strong>IMT:</strong> <span id="modalBmi"></span></p>
                <p><strong>Kategori:</strong> <span id="modalCategory"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="saveBtn">Simpan</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
// Menambahkan event listener untuk form BMI ketika dikirim
document.getElementById('bmiForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Mencegah form dikirim secara default (tidak reload halaman)

    // Mengambil nilai tinggi dari input dan mengubah dari cm ke meter
    const height = parseFloat(document.getElementById('height').value) / 100; // Convert cm to m
    // Mengambil nilai berat dari input
    const weight = parseFloat(document.getElementById('weight').value);

    // Memeriksa apakah tinggi dan berat valid (lebih dari 0)
    if (height > 0 && weight > 0) {
        // Menghitung BMI dengan rumus berat / (tinggi^2) dan membulatkan ke 2 desimal
        const bmi = (weight / (height * height)).toFixed(2);
        let category = ''; // Variabel untuk kategori BMI

        // Menentukan kategori berdasarkan nilai BMI
        if (bmi < 18.5) category = 'Underweight'; // Kurus
        else if (bmi < 25) category = 'Normal'; // Normal
        else if (bmi < 30) category = 'Overweight'; // Kelebihan berat
        else category = 'Obese'; // Obesitas

        // Menampilkan hasil di modal
        document.getElementById('modalHeight').textContent = height; // Tinggi dalam meter
        document.getElementById('modalWeight').textContent = weight; // Berat dalam kg
        document.getElementById('modalBmi').textContent = bmi; // Nilai BMI
        document.getElementById('modalCategory').textContent = category; // Kategori BMI

        // Membuat dan menampilkan modal Bootstrap
        const modal = new bootstrap.Modal(document.getElementById('bmiModal'));
        modal.show();
    }
});

// Menambahkan event listener untuk tombol simpan di modal
document.getElementById('saveBtn').addEventListener('click', function() {
    // Mengambil data dari modal (sudah dalam meter dan kg)
    const height = parseFloat(document.getElementById('modalHeight').textContent); // Already in meters
    const weight = parseFloat(document.getElementById('modalWeight').textContent);

    // Membuat objek data untuk dikirim ke server
    const data = {
        _token: '{{ csrf_token() }}', // Token CSRF untuk keamanan Laravel
        height: height, // Tinggi dalam meter
        weight: weight // Berat dalam kg
    };

    // Mengirim data ke server menggunakan fetch API
    fetch('{{ route("bmi.store") }}', { // URL route untuk menyimpan BMI
        method: 'POST', // Metode HTTP POST
        headers: {
            'Content-Type': 'application/json', // Mengirim data sebagai JSON
            'Accept': 'application/json', // Menerima respons sebagai JSON
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Token CSRF di header
        },
        body: JSON.stringify(data) // Mengubah objek data menjadi string JSON
    })
    .then(response => {
        // Memeriksa apakah respons dari server berhasil
        if (!response.ok) {
            throw new Error('Network response was not ok'); // Jika gagal, lempar error
        }
        return response.json(); // Mengubah respons menjadi objek JSON
    })
    .then(data => {
        // Memeriksa apakah penyimpanan berhasil berdasarkan respons server
        if (data.success) {
            // Menutup modal jika berhasil
            const modal = bootstrap.Modal.getInstance(document.getElementById('bmiModal'));
            modal.hide();
            alert('BMI record saved successfully!'); // Pesan sukses
        } else {
            // Menampilkan pesan error dari server atau pesan default
            alert(data.message || 'Terjadi kesalahan saat menyimpan data.');
        }
    })
    .catch(error => {
        // Menangani error jika terjadi kesalahan dalam proses
        console.error('Error:', error); // Log error ke console
        alert('Terjadi kesalahan saat menyimpan data.'); // Pesan error untuk user
    });
});
</script>
@endpush
