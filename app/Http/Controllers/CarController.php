<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\car;  // A Car modell betöltése, amivel az autók adatai kezelhetők
use Illuminate\Contracts\View\View;  // A View kontraktus, ami a válaszokat adja vissza

class CarController extends Controller
{
    // Az autó rögzítésének űrlapja
    public function create() {
        return view("cars.create");  // Visszaadjuk a 'cars.create' nézetet, ami az autó hozzáadásához szükséges formot tartalmazza
    }

    // Az autó adatainak tárolása
    public function store(Request $request) {
        // A form adatai közül validáljuk a kötelező mezőket és a helyes típusokat
        $request->validate([
            "car_model" => "required|string|max:255",  // Az autó modellje kötelező, string típusú, maximum 255 karakter
            "caution_money" => "required|integer",  // A kaució pénz kötelező, egész szám
            "km_price" => "required|integer",  // A kilométer díj kötelező, egész szám
            "day_price" => "required|integer",  // A napi díj kötelező, egész szám
            "description" => "required|string|max:255"  // A leírás kötelező, maximum 255 karakter
        ]);

        // Létrehozzuk az új autót a form adatai alapján
        car::create($request->all());

        // Átirányítjuk a felhasználót az új autó rögzítéséhez tartozó oldalra, és üzenetet küldünk a sikeres mentésről
        return redirect()->route('cars.create')->with('success', 'Sikeresen rögzítettük az autót');
    }

    // Az elérhető autók listázása
    public function index(Request $request)
    {
        // Lekérdezzük azokat az autókat, amelyek nincsenek bérlés alatt (nem szerepel rent_end adat)
        $query = car::whereDoesntHave('rent', function($q) {
            $q->whereNull('rent_end');  // Csak azok az autók jöhetnek szóba, ahol nincs rent_end dátum
        });

        // Ha van szűrés a car_model alapján, akkor alkalmazzuk
        if ($request->filled('car_model')) {
            $query->where('car_model', $request->input('car_model'));
        }

        // Ha van szűrés a km_price alapján, akkor alkalmazzuk (a km díj ne legyen nagyobb, mint amit a felhasználó beállított)
        if ($request->filled('km_price')) {
            $query->where('km_price', '<=', $request->input('km_price'));
        }

        // A szűrt autók lekérdezése
        $availableCars = $query->get();

        // Az elérhető autók adatainak megjelenítése a 'cars.index' nézetben
        return view('cars.index', compact('availableCars'));
    }

    // Egy adott autó részleteinek megtekintése
    public function show($id)
    {
        // Lekérjük az adott autót az ID alapján
        $car = car::findOrFail($id);

        // Az autó adatainak megjelenítése a 'cars.show' nézetben
        return view('cars.show', compact('car'));
    }
}
