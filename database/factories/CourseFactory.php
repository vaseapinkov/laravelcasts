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
            'slug' => $this->faker->slug,
            'title' => $this->faker->sentence,
            'tagline' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'image_name' => 'image.png',
            'learnings' => ['Learn A', 'Learn C', 'Learn B'],
            'paddle_product_id' => $this->faker->uuid,
        ];
    }

    public function relased(Carbon $date = null): self
    {
        return $this->state(
            fn ($attributes) => ['released_at' => $date ?? Carbon::now()]
        );
    }
}
