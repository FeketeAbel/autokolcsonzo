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
        // A "cars" tábla létrehozása
        Schema::create('cars', function (Blueprint $table) {
            // Azonosító oszlop
            $table->id();
            
            // Autó modellje (pl. "Toyota Corolla")
            $table->string("car_model");

            // Kaució összege
            $table->integer("caution_money");

            // Kilométer díj
            $table->integer("km_price");

            // Napi bérleti díj
            $table->integer("day_price");

            // Rövid leírás az autóról
            $table->string("description");

            // Soft delete mező: Ha az autót törlik, nem kerül véglegesen törlésre, csak "soft delete"-ként
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
        // Ha a migrációt visszavonjuk, akkor törli a "cars" táblát
        Schema::dropIfExists('cars');
    }
};

