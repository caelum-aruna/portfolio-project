<?php

namespace Database\Factories;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Skill>
 */
class SkillFactory extends Factory
{
    protected $model = Skill::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
            'category' => fake()->randomElement(['Frontend', 'Backend', 'Tools & DevOps', 'Mobile']),
            'icon' => 'code',
            'proficiency' => fake()->numberBetween(60, 100),
            'order' => fake()->numberBetween(1, 20),
        ];
    }
}
