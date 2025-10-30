@extends('templates.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">BMI Calculator</h3>
                </div>
                <div class="card-body">
                    <form id="bmiForm">
                        @csrf
                        <div class="mb-3">
                            <label for="height" class="form-label">Height (cm)</label>
                            <input type="number" step="0.01" class="form-control" id="height" name="height" required>
                        </div>
                        <div class="mb-3">
                            <label for="weight" class="form-label">Weight (kg)</label>
                            <input type="number" step="0.1" class="form-control" id="weight" name="weight" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Calculate BMI</button>
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
                <p><strong>Height:</strong> <span id="modalHeight"></span> cm</p>
                <p><strong>Weight:</strong> <span id="modalWeight"></span> kg</p>
                <p><strong>BMI:</strong> <span id="modalBmi"></span></p>
                <p><strong>Category:</strong> <span id="modalCategory"></span></p>
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
document.getElementById('bmiForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const height = parseFloat(document.getElementById('height').value) / 100; // Convert cm to m
    const weight = parseFloat(document.getElementById('weight').value);

    if (height > 0 && weight > 0) {
        const bmi = (weight / (height * height)).toFixed(2);
        let category = '';

        if (bmi < 18.5) category = 'Underweight';
        else if (bmi < 25) category = 'Normal';
        else if (bmi < 30) category = 'Overweight';
        else category = 'Obese';

        // Populate modal
        document.getElementById('modalHeight').textContent = height;
        document.getElementById('modalWeight').textContent = weight;
        document.getElementById('modalBmi').textContent = bmi;
        document.getElementById('modalCategory').textContent = category;

        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('bmiModal'));
        modal.show();
    }
});

document.getElementById('saveBtn').addEventListener('click', function() {
    const height = parseFloat(document.getElementById('modalHeight').textContent); // Already in meters
    const weight = parseFloat(document.getElementById('modalWeight').textContent);

    // Prepare data for AJAX request
    const data = {
        _token: '{{ csrf_token() }}',
        height: height,
        weight: weight
    };

    // Send AJAX request to save BMI record
    fetch('{{ route("bmi.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // On success, close the modal and show success message
            const modal = bootstrap.Modal.getInstance(document.getElementById('bmiModal'));
            modal.hide();
            alert('BMI record saved successfully!');
        } else {
            // Handle validation or other errors
            alert(data.message || 'Terjadi kesalahan saat menyimpan data.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menyimpan data.');
    });
});
</script>
@endpush
