<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Krishi Bondhu</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .placeholder-home {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 20px;
            text-align: center;
            background: linear-gradient(135deg, var(--color-primary-dark), var(--color-secondary));
            color: #fff;
            padding: 24px;
        }
        .placeholder-home h1 { font-size: 40px; margin: 0; }
        .placeholder-home p { max-width: 460px; opacity: 0.9; }
        .placeholder-home .btn-row { display: flex; gap: 12px; }
    </style>
</head>
<body>
    <div class="placeholder-home">
        <h1>🌾 Krishi Bondhu</h1>
        <p>
            The full public home page 
        </p>
        <div class="btn-row">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
            @endauth
        </div>
    </div>
</body>
</html>
