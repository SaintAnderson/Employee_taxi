<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Car;
use App\Models\Driver;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    protected $model = Car::class;

    public function definition(): array
    {
        $models = ['Toyota Camry', 'Honda Accord', 'BMW 5 Series', 'Audi A6', 'Mercedes-Benz E-Class'];
        $comfortCategories = [1, 2, 3, 4, 5];

        return [
            'model' => $this->faker->randomElement($models),
            'comfort_category' => $this->faker->randomElement($comfortCategories),
            'driver_id' => Driver::factory(), // Связанный водитель
        ];
    }
}
