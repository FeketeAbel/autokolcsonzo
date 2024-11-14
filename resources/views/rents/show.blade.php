<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  <!-- Az oldal karakterkódolásának beállítása, hogy a magyar karakterek helyesen jelenjenek meg -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  <!-- Reszponzív designhoz szükséges meta tag -->
    <title>Bérlés Részletei</title>  <!-- Az oldal címe -->
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
    
    <h1>Bérlés részletei</h1>  <!-- Az oldal főcímsora -->

    <!-- A bérlés részleteinek megjelenítése -->
    <p>Autó model: {{ $rent->car->car_model }}</p>  <!-- Az autó modelljének megjelenítése -->
    <p>Email: {{ $rent->email }}</p>  <!-- A bérlő email címének megjelenítése -->
    <p>Kölcsönzés kezdete: {{ $rent->rent_start }}</p>  <!-- A bérlés kezdő dátuma -->

    <!-- Bérlés lezárásához szükséges form -->
    <form action="{{ route('rents.update', $rent->id) }}" method="POST">  <!-- Az űrlap a 'rents.update' route-ra küldi az adatokat, PUT metódust használva -->
        @csrf  <!-- A CSRF token hozzáadása a biztonság érdekében -->
        @method('PUT')  <!-- Az adatbázisban a PUT metódus jelezni fogja, hogy a bérlés frissítése történik -->
        
        <!-- Bérlés lezárásához szükséges dátum és kilométer adatok -->
        <label for="rent_end">Visszavétel dátuma:</label>
        <input type="date" name="rent_end" required>  <!-- A bérlés visszavételének dátuma -->
        
        <label for="km">Levezetett kilométer:</label>
        <input type="number" name="km" required>  <!-- A bérlés során levezetett kilométerek száma -->
        
        <button type="submit">Mentés</button>  <!-- A form elküldése a frissítések mentésére -->
    </form>
</body>
</html>
