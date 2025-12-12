<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Aktivitas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .summary {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
        }
        .row {
            display: flex;
            margin-bottom: 10px;
        }
        .col {
            flex: 1;
            padding: 0 10px;
        }
        .col strong {
            display: block;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Ringkasan Aktivitas</h1>
        <p>Selamat! Anda telah menyelesaikan sesi latihan Anda.</p>
    </div>

    <div class="summary">
        <h2>Detail Sesi</h2>
        <div class="row">
            <div class="col">
                <strong>Aktivitas:</strong> {{ $session->physicalActivity->name }}
            </div>
            <div class="col">
                <strong>Durasi:</strong> {{ $session->duration_minutes }} minutes
            </div>
        </div>
        <div class="row">
            <div class="col">
                <strong>Kalori Terbakar:</strong> {{ $session->calories_burned }} calories
            </div>
            <div class="col">
                <strong>Selesai Pada:</strong> {{ $session->finished_at->format('d M Y H:i') }}
            </div>
        </div>
        <div class="row">
            <div class="col">
                <strong>Nama Pengguna:</strong> {{ $session->user->name }}
            </div>
        </div>
    </div>
</body>
</html>
