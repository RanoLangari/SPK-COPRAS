<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Kriteria;
use App\Models\SubKriteria;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kriteria>
 */
class KriteriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_kriteria' => $this->faker->name(),
            'bobot' => $this->faker->randomFloat(2, 0, 1),
            'tipe' => $this->faker->randomElement(['benefit', 'cost'])
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Kriteria $kriteria) {
            SubKriteria::factory()->count(3)->create([
                'kriteria_id' => $kriteria->id
            ]);
        });
    }

    
}
