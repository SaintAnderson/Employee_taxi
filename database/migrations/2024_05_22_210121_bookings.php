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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('car_id');
            $table->unsignedBigInteger('employee_id');
            $table->timestamp('start_time');
            $table->timestamp('end_time')->nullable();
            $table->timestamps();

            // Связь с таблицей cars
            $table->foreign('car_id')->references('id')->on('cars')
                ->onDelete('cascade'); // При удалении автомобиля, удаляются и его бронирования

            // Связь с таблицей employees
            $table->foreign('employee_id')->references('id')->on('employees')
                ->onDelete('cascade'); // При удалении сотрудника, удаляются и его бронирования
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
