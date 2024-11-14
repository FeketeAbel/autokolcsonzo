<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // A "rents" tábla létrehozása
        Schema::create('rents', function (Blueprint $table) {
            // Azonosító oszlop
            $table->id();
            
            // Kapcsolódás a "cars" táblához a "car_id" mezőn keresztül, és ha egy autót törölnek, akkor a hozzá tartozó bérlések is törlődnek
            $table->foreignId("car_id")->constrained()->onDelete("cascade");

            // A bérlő email címe
            $table->string("email");

            // A kölcsönzés kezdete
            $table->date("rent_start")->nullable();

            // A kölcsönzés vége (visszavétel dátuma)
            $table->date("rent_end")->nullable();

            // Az autó által megtett kilométerek száma
            $table->integer("km")->nullable();

            // Az összes bérleti díj
            $table->integer("all_price")->nullable();

            // Soft delete mező, azaz nem törlődik véglegesen, hanem archiválódik
            $table->softDeletes();

            // Automatikusan hozzáadja a created_at és updated_at időbélyegeket
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Ha a migrációt visszavonjuk, töröljük a "rents" táblát
        Schema::dropIfExists('rents');
    }
};
