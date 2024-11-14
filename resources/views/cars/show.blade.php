<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  <!-- A karakterkódolás beállítása (UTF-8) -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  <!-- A reszponzív designhoz szükséges meta tag, hogy megfelelően jelenjen meg különböző eszközökön -->
    <title>Autó Részletei</title>  <!-- Az oldal címének beállítása -->
</head>
<body>
    <!-- Ha van valamilyen hiba, azt listázza ki -->
    @if($errors->any())
        <ul>
            <!-- Minden hibát végigjárunk és megjelenítjük egy listaelemben -->
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif

    <!-- Ha van sikeres üzenet a session-ban, azt megjelenítjük -->
    @if (session('success'))
        {{ session('success') }}
    @endif
    
    <!-- Az autó modelljének megjelenítése főcímen -->
    <h1>{{ $car->car_model }}</h1>

    <!-- Az autó egyéb adatai (kaució, napi díj, kilométer díj, leírás) -->
    <p><strong>Kaució:</strong> {{ $car->caution_money }} Ft</p>
    <p><strong>Napi díj:</strong> {{ $car->day_price }} Ft</p>
    <p><strong>Kilométer díj:</strong> {{ $car->km_price }} Ft</p>
    <p><strong>Leírás:</strong> {{ $car->description }}</p>

    <!-- Kölcsönzési űrlap -->
    <form action="{{ route('rents.store') }}" method="POST">
        @csrf  <!-- CSRF token generálása a form biztonságos elküldéséhez -->
        
        <!-- A kiválasztott autó ID-jának elrejtése a formban -->
        <input type="hidden" name="car_id" value="{{ $car->id }}">

        <!-- A kölcsönzési űrlap mezői -->
        <label for="email">Email cím:</label>  <!-- Az email cím mező címkéje -->
        <input type="email" name="email" required>  <!-- Email cím beviteli mező -->
        
        <label for="rent_start">Kölcsönzés kezdete:</label>  <!-- Kölcsönzés kezdete címkéje -->
        <input type="date" name="rent_start" required>  <!-- Kölcsönzés kezdete dátum mező -->
        
        <!-- A kölcsönzés elküldésére szolgáló gomb -->
        <button type="submit">Kölcsönzés</button>
    </form>
</body>
</html>
