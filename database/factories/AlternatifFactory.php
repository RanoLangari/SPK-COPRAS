<?php

namespace Database\Factories;

use App\Models\Alternatif;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Alternatif>
 */
class AlternatifFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Alternatif::class;
    public function definition(): array
    {
        return [
            'nama_alternatif' => $this->faker->name()
        ];
    }
}
