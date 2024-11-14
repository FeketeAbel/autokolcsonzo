<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class car extends Model
{
    // A soft delete funkció engedélyezése, hogy az objektumok törlésénél ne kerüljenek véglegesen eltávolításra.
    use SoftDeletes;

    // Az oszlopok, amik tömegesen hozzárendelhetők (mass assignment)
    protected $fillable = [
        "car_model",       // Az autó modellje
        "caution_money",   // Kaució
        "km_price",        // Kilométer díj
        "day_price",       // Napi díj
        "description"      // Leírás
    ];

    /**
     * A kapcsolat a bérlés modellel.
     * Ez a kapcsolat azt jelenti, hogy egy autóhoz több bérlés is tartozhat.
     */
    public function rent(){
        return $this->hasMany(Rent::class);
    }
}

