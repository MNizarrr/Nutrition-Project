<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercise Summary</title>
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
        <h1>Exercise Summary</h1>
        <p>Congratulations! You have completed your exercise session.</p>
    </div>

    <div class="summary">
        <h2>Session Details</h2>
        <div class="row">
            <div class="col">
                <strong>Activity:</strong> {{ $session->physicalActivity->name }}
            </div>
            <div class="col">
                <strong>Duration:</strong> {{ $session->duration_minutes }} minutes
            </div>
        </div>
        <div class="row">
            <div class="col">
                <strong>Calories Burned:</strong> {{ $session->calories_burned }} calories
            </div>
            <div class="col">
                <strong>Finished At:</strong> {{ $session->finished_at->format('d M Y H:i') }}
            </div>
        </div>
        <div class="row">
            <div class="col">
                <strong>User:</strong> {{ $session->user->name }}
            </div>
        </div>
    </div>
</body>
</html>
