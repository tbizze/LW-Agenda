<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recibo>
 */
class ReciboFactory extends Factory
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
            'valor' => $this->faker->randomNumber(3)*0.25,
            'historico' => $this->faker->sentence(3),
            'data' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'local' => $this->faker->city(),
            'pagador' => $this->faker->name(),
            'cpf_cnpj_pagad'=> $this->faker->cnpj(false),
            'recebedor'=> $this->faker->name(),
            'cpf_cnpj_receb'=> $this->faker->cnpj(false), 
        ];
    }
}
