<?php

namespace Database\Factories;

use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->jobTitle . ' (' . $this->faker->randomElement(['Junior', 'Senior', 'Remote']) . ')';
        return [
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title) . '-' . \Illuminate\Support\Str::random(5),

            'company_id' => $this->faker->numberBetween(1, 10), // Random lấy 1 trong 10 công ty sẽ tạo

            'salary' => $this->faker->randomElement(['10 - 15 Triệu', '15 - 25 Triệu', 'Thỏa thuận']),
            'location' => $this->faker->randomElement(['Hà Nội', 'TP. Hồ Chí Minh', 'Đà Nẵng']),
            'experience' => $this->faker->randomElement(['Không yêu cầu', '1 năm', '3 năm']),
            'deadline' => $this->faker->dateTimeBetween('now', '+2 months'),
            'description' => $this->faker->paragraphs(3, true),
            'requirements' => $this->faker->paragraphs(2, true),
            'benefits' => $this->faker->paragraphs(2, true),
            'category_id' => $this->faker->numberBetween(1, 5),
            'employer_id' => 1,
            'is_active' => true,
        ];
    }
}
