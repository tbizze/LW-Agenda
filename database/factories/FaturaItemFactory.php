<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FaturaItem>
 */
class FaturaItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'dt_compra' => $this->faker->dateTimeBetween('-6 month', 'now'),
            'valor_compra' => $this->faker->randomFloat(2, 15, 300),
            'historico' => $this->faker->sentence(3),
            'parcela' => $this->faker->numberBetween(0, 5),
            'notas' => $this->faker->sentence(3),

            'fatura_grupo_id' => $this->faker->numberBetween(1, 4),
            'fatura_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
