<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\RentController;
use Illuminate\Support\Facades\Route;

// Kezdőlap
Route::get('/', function () {
    return view('welcome');
});

// Autókkal kapcsolatos útvonalak
// Új autó hozzáadásának űrlapja
Route::get("/new-car", [CarController::class, "create"])->name("cars.create");
// Új autó mentése
Route::post("/new-car", [CarController::class, "store"])->name("cars.store");
// Az összes autó listázása
Route::get("/cars", [CarController::class, "index"])->name("cars.index");
// Egy adott autó részleteinek megjelenítése
Route::get("/cars/{id}", [CarController::class, "show"])->name("cars.show");

// Bérlésekkel kapcsolatos útvonalak
// Az összes bérlés listázása, szűrési lehetőséggel a folyamatban lévő bérlésekhez
Route::get('/rents', [RentController::class, 'index'])->name('rents.index');
// Új bérlés mentése
Route::post('/rents', [RentController::class, 'store'])->name('rents.store'); 
// Egy adott bérlés részleteinek megjelenítése
Route::get('/rents/{id}', [RentController::class, 'show'])->name('rents.show'); 
// A bérlés frissítése (pl. visszavétel vagy km alapján)
Route::put('/rents/{id}', [RentController::class, 'update'])->name('rents.update'); 

// Opcionális törlés útvonal
// Route::delete('/rents/{id}', [RentController::class, 'destroy'])->name('rents.destroy');
