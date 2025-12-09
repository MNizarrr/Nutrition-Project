@extends('templates.app')

@section('content')
    <div class="container mt-5">
        <h5>Dashboard Admin</h5>
        @if (Session::get('success'))
            <div class="alert alert-success">{{Session::get('success')}}<b> Selamat Datang, {{Auth::user()->name}}</b></div>
        @endif
        <div class="row">
            <div class="col-6">
                <h5>Data BMI Records Bulan {{ now()->format('F') }}</h5>
                <canvas id="chartBar"></canvas>
                <h5>Data Jumlah Yang Beraktivitas {{ now()->format('F') }}</h5>
                <canvas id="chartBarActivities"></canvas>
            </div>
            <div class="col-6">
                <h5>Aktivitas Fisik Aktif dan Non-Aktif</h5>
                <canvas id="chartDoughnut" style="width: 100px; height: 10px;"></canvas>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let labelsBar = [];
        let dataBar = [];
        let dataDoughnut = [];

        // Chart Bar
        $.ajax({
            url: "{{ route('admin.bmi.chart') }}",
            method: "GET",
            success: function (response) {
                labelsBar = response.labels;
                dataBar = response.data;
                showChartBar();
            },
            error: function () {
                alert('Gagal mengambil data chart BMI!')
            }
        });

        // Chart Doughnut
        $.ajax({
            url: "{{ route('admin.activities.chart') }}",
            method: "GET",
            success: function (response) {
                dataDoughnut = response.data;
                showChartDoughnut(); // <-- WAJIB dipanggil
            },
            error: function () {
                alert('Gagal mengambil data chart aktivitas!')
            }
        });

        // Chart Bar Activities
        $.ajax({
            url: "{{ route('admin.active.users.chart') }}",
            method: "GET",
            success: function (response) {
                dataBarActivities = [response.data];
                showChartBarActivities();
            },
            error: function () {
                alert('Gagal mengambil data chart pengguna aktif!')
            }
        });

        function showChartBar() {
            const ctx = document.getElementById('chartBar');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labelsBar,
                    datasets: [{
                        label: 'Jumlah BMI Records',
                        data: dataBar,
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        }

        function showChartDoughnut() {
            const ctx2 = document.getElementById('chartDoughnut'); // FIXED

            new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: ['Aktivitas Aktif', 'Aktivitas Non-Aktif'],
                    datasets: [{
                        label: 'Perbandingan Aktivitas',
                        data: dataDoughnut,
                        backgroundColor: [
                            'rgb(0, 255, 0)',
                            'rgb(255, 0, 0)'
                        ],
                        hoverOffset: 4
                    }]
                }
            });
        }

        function showChartBarActivities() {
            const ctx3 = document.getElementById('chartBarActivities');
            new Chart(ctx3, {
                type: 'bar',
                data: {
                    labels: ['Pengguna Aktif'],
                    datasets: [{
                        label: 'Jumlah Pengguna Yang Melakukan Aktivitas',
                        data: dataBarActivities,
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        }
    });
</script>
@endpush
