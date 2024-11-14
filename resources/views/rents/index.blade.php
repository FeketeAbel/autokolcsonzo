<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  <!-- A karakterkódolás beállítása (UTF-8), hogy a magyar karakterek helyesen jelenjenek meg -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  <!-- A reszponzív designhoz szükséges meta tag, hogy az oldal különböző eszközökön jól nézzen ki -->
    <title>Bérlések</title>  <!-- Az oldal címének beállítása -->
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
    
    <h1>Bérlések</h1>  <!-- Az oldal főcímsora -->

    <!-- Szűrő űrlap a folyamatban lévő bérlések szűréséhez -->
    <form action="{{ route('rents.index') }}" method="GET">  <!-- A form a GET metódussal küldi el az adatokat a 'rents.index' route-ra -->
        <label for="in_progress">Folyamatban lévő bérlések:</label>
        <input type="checkbox" name="in_progress" value="1" {{ request('in_progress') ? 'checked' : '' }}>  <!-- Checkbox, ami csak akkor lesz bepipálva, ha a 'in_progress' paraméter van az URL-ben -->
        <button type="submit">Szűrés</button>  <!-- Szűrés gomb -->
    </form>

    <!-- Bérlések listázása -->
    <ul>
        @foreach($rents as $rent)  <!-- A bérlések listájának kiírása -->
            <li>
                <p>Autó: {{ $rent->car->car_model }}</p>  <!-- Az autó modelljének megjelenítése -->
                <p>Email: {{ $rent->email }}</p>  <!-- A bérlő email címének megjelenítése -->
                <p>Kölcsönzés kezdete: {{ $rent->rent_start }}</p>  <!-- A bérlés kezdő dátumának megjelenítése -->
                @if(is_null($rent->rent_end))  <!-- Ha a bérlés még nem zárult le -->
                    <a href="{{ route('rents.show', $rent->id) }}">Visszavétel</a>  <!-- A "Visszavétel" link, amely a bérlés részleteit mutatja -->
                @else  <!-- Ha a bérlés már lezárult -->
                    <p>Befejezve: {{ $rent->rent_end }}</p>  <!-- A bérlés befejezési dátumának megjelenítése -->
                @endif
            </li>
        @endforeach
    </ul>
</body>
</html>

        @endforeach
    </ul>
</body>
</html>
