<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  <!-- A karakterkódolás beállítása (UTF-8) -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  <!-- A reszponzív designhoz szükséges meta tag, hogy megfelelően jelenjen meg különböző eszközökön -->
    <title>Elérhető autók</title>  <!-- Az oldal címének beállítása -->
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
    
    <h1>Elérhető autók</h1>  <!-- Oldal főcímsora -->

    <!-- Szűrő űrlap -->
    <form action="{{ route('cars.index') }}" method="GET">
        <!-- A GET metódusú űrlap, amely a 'cars.index' route-ra küldi az adatokat -->
        <label for="car_model">Model:</label>  <!-- Az autó modelljének szűrőjéhez tartozó címke -->
        <input type="text" name="car_model" id="car_model" value="{{ request('car_model') }}">  <!-- Autó modelljének beviteli mezője, alapértelmezett értékként a korábbi keresés értékét jeleníti meg -->
        
        <label for="km_price">Max km díj:</label>  <!-- A maximális kilométer díj szűrőjéhez tartozó címke -->
        <input type="number" name="km_price" id="km_price" value="{{ request('km_price') }}">  <!-- A kilométer díj szűréséhez beviteli mező, alapértelmezett értékként a korábbi keresési értéket jeleníti meg -->
        
        <button type="submit">Szűrés</button>  <!-- Szűrés gomb, amely elküldi az űrlapot -->
    </form>

    <!-- Ha nincs elérhető autó, akkor ezt a szöveget jelenítjük meg -->
    @if($availableCars->isEmpty())
        <p>Nincsenek elérhető autók jelenleg.</p>
    @else
        <!-- Ha vannak elérhető autók, akkor listázza őket -->
        <ul>
            @foreach($availableCars as $car)  <!-- A rendelkezésre álló autók végigiterálása -->
                <li>
                    <!-- Az autó adatainak megjelenítése -->
                    <strong>Model:</strong> {{ $car->car_model }}<br>  <!-- Az autó modellje -->
                    <strong>Kaució:</strong> {{ $car->caution_money }} Ft<br>  <!-- Az autó kauciója -->
                    <strong>Napi díj:</strong> {{ $car->day_price}} Ft<br>  <!-- Az autó napi díja -->
                    <strong>Kilométer díj:</strong> {{ $car->km_price }} Ft<br>  <!-- Az autó kilométer díja -->
                    <!-- Hivatkozás az adott autó részletes oldalára -->
                    <a href="{{ route('cars.show', $car->id) }}">Megnézem</a>
                </li>
            @endforeach
        </ul>
    @endif
</body>
</html>
