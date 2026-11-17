<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(3);

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(1000, 9999),
            'category' => fake()->randomElement(['Full Stack', 'Frontend', 'Backend', 'Mobile']),
            'description' => fake()->paragraph(),
            'details' => fake()->paragraphs(2, true),
            'thumbnail' => '/images/sample.png',
            'tech_stack' => ['Laravel', 'Vue.js', 'Tailwind CSS'],
            'demo_url' => fake()->url(),
            'repo_url' => fake()->url(),
            'is_featured' => true,
            'order' => fake()->numberBetween(1, 10),
        ];
    }

    /**
     * Indicate that the project is featured.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    /**
     * Indicate that the project is not featured.
     */
    public function unfeatured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => false,
        ]);
    }
}
