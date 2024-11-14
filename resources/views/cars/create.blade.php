<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  <!-- A karakterkódolás beállítása (UTF-8), hogy a magyar karakterek helyesen jelenjenek meg -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  <!-- A reszponzív designhoz szükséges meta tag, hogy az oldal különböző eszközökön jól nézzen ki -->
    <title>Document</title>  <!-- Az oldal címének beállítása -->
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


    <!-- Autó adatainak hozzáadása, form a 'cars.store' route-ra -->
    <form action="{{ route('cars.store') }}" method="post">  <!-- A form POST metódussal küldi el az adatokat a 'cars.store' route-ra -->
        @csrf  <!-- CSRF token hozzáadása a biztonságos adatküldéshez -->
        
        <!-- Autó modelljének megadása -->
        <label for="car_model">Autómodell:</label>
        <input type="text" name="car_model" id="car_model"><br>  <!-- Az autó modelljének beviteli mezője -->

        <!-- Kaució megadása -->
        <label for="caution_money">Kaució:</label>
        <input type="text" name="caution_money" id="caution_money"><br>  <!-- Kaució beviteli mezője -->

        <!-- Kilométer díj megadása -->
        <label for="km_price">km-díj:</label>
        <input type="text" name="km_price" id="km_price"><br>  <!-- Kilométer díj beviteli mezője -->

        <!-- Napi díj megadása -->
        <label for="day_price">napidíj:</label>
        <input type="text" name="day_price" id="day_price"><br>  <!-- Napi díj beviteli mezője -->

        <!-- Leírás megadása -->
        <label for="description">Leírás:</label>
        <input type="text" name="description" id="description"><br>  <!-- Az autó leírása beviteli mezője -->

        <!-- A form elküldésére szolgáló gomb -->
        <button type="submit">Feltölt</button>
    </form>
</body>
</html>
