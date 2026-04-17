<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'Công ty ' . $this->faker->company,
            'address' => $this->faker->address,
            'tax_code' => $this->faker->numerify('##########'), // Random 10 số
            'email' => $this->faker->unique()->companyEmail,
            'hotline' => $this->faker->phoneNumber,
            'logo' => 'https://via.placeholder.com/100', // Logo công ty
            'description' => $this->faker->paragraphs(2, true),
        ];
    }
}

?>