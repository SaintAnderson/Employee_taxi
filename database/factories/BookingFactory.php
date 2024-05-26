<?php

namespace Database\Factories;
use App\Models\Car;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Booking;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        // Генерируем случайные дату для начала бронирования
        // Генерация случайного времени в формате 'H:i'
        $startHourMinutes = $this->faker->time('H:i');
        $startDateTime = \DateTime::createFromFormat('Y-m-d H:i', '2024-01-01 ' . $startHourMinutes);

        // Генерация случайного времени окончания (в пределах трех часов от начала)
        $endDateTime = (clone $startDateTime)->modify('+' . $this->faker->numberBetween(1, 180) . ' minutes');

        return [
            'car_id' => Car::factory(), // Связанный автомобиль
            'employee_id' => Employee::factory(), // Связанный сотрудник
            'start_time' => $startDateTime,
            'end_time' => $endDateTime,
        ];
    }
}
