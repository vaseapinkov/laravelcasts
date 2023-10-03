<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];
    }

    public function relased(Carbon $date = null): self
    {
        return $this->state(
            fn ($attributes) => ['released_at' => $date ?? Carbon::now()]
        );
    }
}
