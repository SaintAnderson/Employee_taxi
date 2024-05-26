<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use  App\Models\Employee;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition()
    {
        // Определим возможные должности и категории комфорта
        $jobTitles = ['Менеджер', 'Разработчик', 'Аналитик', 'Дизайнер', 'Тестировщик', 'Администратор'];
        $comfortCategories = [1, 2, 3, 4, 5];

        return [
            'position' => $this->faker->randomElement($jobTitles),
            'allowed_comfort_categories' => json_encode($this->faker->randomElements($comfortCategories, $this->faker->numberBetween(1, count($comfortCategories)))),
        ];
    }

}
