<?php

namespace App\Http\Controllers;
use App\Models\Driver;
use App\Models\Employee;
use App\Models\Car;
use Illuminate\Http\Request;
class CarController extends Controller
{
    public function getAvailableCars(Request $request) {
        $employeeId = $request->employee_id; // ID сотрудника
        $startTime = '2024-01-01' . ' ' . $request->start_time; // Время начала поездки
        $endTime = '2024-01-01' . ' ' . $request->end_time; // Время окончания поездки

        // Получите категории комфорта, доступные для сотрудника
        $employee = Employee::find($employeeId);

        $allowedCategories = json_decode($employee->allowed_comfort_categories);

        // Найдите все автомобили, которые не забронированы на запланированное время
        $availableCars = Car::whereIn('comfort_category', $allowedCategories)
            ->whereDoesntHave('bookings', function($query) use ($startTime, $endTime) {
                $query->where(function($query) use ($startTime, $endTime) {
                    $query->where('start_time', '<', $endTime)
                        ->where('end_time', '>', $startTime);
                });
            })
            ->get();
        // Добавляем поле Drivername к каждому объекту автомобиля
        $availableCars = $availableCars->map(function ($car) {
            $car->Drivername = $car->driver ? $car->driver->name : 'Без водителя';
            return $car;
        });
        return response()->json($availableCars);
    }
}
