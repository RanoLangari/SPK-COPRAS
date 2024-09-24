<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Nilai;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubKriteria>
 */
class SubKriteriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = SubKriteria::class;
    public function definition(): array
    {
        return [
            'nama_subkriteria' => $this->faker->name(),
            'bobot' => $this->faker->numberBetween(1, 5) * 1,
        ];
    }

}
