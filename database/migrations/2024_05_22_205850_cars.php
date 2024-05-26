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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->integer('comfort_category');
            $table->unsignedBigInteger('driver_id');
            $table->timestamps();

            // Связь с таблицей drivers
            $table->foreign('driver_id')->references('id')->on('drivers')
                ->onDelete('cascade'); // При удалении водителя, удаляются и его машины
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
