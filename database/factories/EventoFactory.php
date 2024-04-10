<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evento>
 */
class EventoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $data_inicio = $this->faker->dateTimeBetween('2024-01-01', '+ 30 days');
        //$data_inicio = $this->faker->dateTimeBetween('2024-01-01', '2024-12-01');
        $data_fim = $this->faker->dateTimeBetween('2024-01-01','+ 30 days');
        /* dd($data_fim);
        dd($data_inicio);
        $var_data = $data_inicio . '||' . $data_fim;
        //dd($startDate); */
        return [
            //
            'nome' => $this->faker->sentence(3),
            'start_date' => $data_inicio,
            'end_date' => $data_fim,
            'start_time' => $this->faker->time('H:i'),
            //'end_time'=> $this->faker->stateAbbr(),

            'notas'=> $this->faker->sentence(3),

            'evento_grupo_id'=> $this->faker->numberBetween(1, 17), 
            'evento_local_id'=> $this->faker->numberBetween(1, 5), 
        ];
    }
}
