<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\car;
use App\Models\rent;

class RentController extends Controller
{
    // A kölcsönzés rögzítése (store)
    public function store(Request $request)
    {
        // Kérjük be és validáljuk a form adatokat: email, kölcsönzés kezdete, autó ID
        $request->validate([
            'email' => 'required|email',             // Az email mező kötelező, és érvényes email formátumot vár
            'rent_start' => 'required|date',         // A bérlés kezdete kötelező és érvényes dátum
            'car_id' => 'required|exists:cars,id'    // Az autó ID kötelező és léteznie kell a cars táblában
        ]);

        // Létrehozzuk a bérlést az adatokkal
        rent::create([
            'email' => $request->input('email'),    // Az email cím
            'rent_start' => $request->input('rent_start'),  // A bérlés kezdete
            'car_id' => $request->input('car_id'),   // Az autó ID-ja
        ]);

        // Átirányítjuk a felhasználót a bérlések listájához, és üzenetet jelenítünk meg
        return redirect()->route('rents.index')->with('success', 'Bérlés sikeresen létrehozva.');
    }

    // A bérlések listázása, opcionális szűréssel
    public function index(Request $request)
    {
        // A lekérdezés előkészítése: az összes bérlés és kapcsolódó autó adatainak betöltése
        $query = rent::with('car');

        // Ha a felhasználó a "folyamatban van" szűrési lehetőséget választotta
        if ($request->has('in_progress')) {
            // Csak a bérlések, ahol nincs rent_end dátum, tehát folyamatban lévő bérlés
            $query->whereNull('rent_end');
        }

        // A szűrt bérlések lekérdezése
        $rents = $query->get();

        // A bérlések listázása a view-ban
        return view('rents.index', compact('rents'));
    }

    // A bérlés frissítése (például bérlés lezárása)
    public function update(Request $request, $id)
    {
        // Kérjük be és validáljuk az adatokat: rent_end dátum és km megtett érték
        $request->validate([
            'rent_end' => 'required|date|after_or_equal:rent_start', // rent_end dátum kötelező és a rent_start után kell lennie
            'km_driven' => 'required|integer|min:0',  // A megtett km kötelező és nem lehet negatív
        ]);

        // A bérlés és kapcsolódó autó lekérdezése
        $rent = rent::findOrFail($id);
        $car = $rent->car;

        // A bérlés ideje: rent_start és rent_end közötti napok száma
        $days = $rent->rent_start->diffInDays($request->input('rent_end')) ?: 1; // Ha nincs eltérés, akkor 1 napot számolunk
        // A teljes ár kiszámítása a napi díj és a megtett kilométerek alapján
        $total_price = ($days * $car->day_price) + ($request->input('km_driven') * $car->km_price);

        // A bérlés frissítése a rent_end dátummal, km megtett értékkel és a kiszámított ár
        $rent->update([
            'rent_end' => $request->input('rent_end'),
            'km_driven' => $request->input('km_driven'),
            'all_price' => $total_price, // Az összes ár a napi díj és km díj alapján
        ]);

        // Átirányítás a bérlések listájához, és sikeres frissítés üzenet
        return redirect()->route('rents.index')->with('success', 'Bérlés sikeresen lezárva.');
    }

    // Egy adott bérlés adatainak megtekintése
    public function show($id)
    {
        // A bérlés és az autó adatainak lekérdezése
        $rent = rent::findOrFail($id);
        $car = $rent->car;

        // A bérlés és autó adatainak megjelenítése a view-ban
        return view('rents.show', compact('rent', 'car'));
    }
}
