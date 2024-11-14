<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class rent extends Model
{
    // A soft delete funkció engedélyezése
    use SoftDeletes;

    // Az oszlopok, amik tömegesen hozzárendelhetők (mass assignment)
    protected $fillable = [
        "email",        // Email cím a bérlőtől
        "car_id",       // Az autó ID-ja, amit bérletek
        "rent_start",   // Bérlés kezdete
        "rent_end",     // Bérlés vége (ha befejeződött)
        "km",           // A levezetett kilométerek száma
        "all_price"     // A bérlés összesített ára
    ];

    /**
     * A kapcsolat az autó modellel.
     * Ez a kapcsolat azt jelenti, hogy minden bérléshez tartozik egy autó (egy bérlés, egy autó).
     */
    public function car(){
        return $this->belongsTo(Car::class);
    }
}

