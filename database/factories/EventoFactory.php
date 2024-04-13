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
        $data_fim = $data_inicio;
        $start_time = $this->faker->randomElement(['06:00','07:00','08:00','10:00','10:30','14:00','16:00','19:00','20:00']);;
        $end_time = $this->faker->dateTimeInInterval($start_time, '+2 hour');
        //$data_inicio = $this->faker->dateTimeBetween('2024-01-01', '2024-12-01');
        /* dd($data_fim);
        dd($data_inicio);
        $var_data = $data_inicio . '||' . $data_fim;
        //dd($startDate); */
        return [
            //
            'nome' => $this->faker->sentence(3),
            'start_date' => $data_inicio,
            'end_date' => $data_fim,
            'start_time' => $start_time,
            'end_time'=> $end_time,

            'notas'=> $this->faker->sentence(3),

            'evento_grupo_id'=> $this->faker->numberBetween(1, 17), 
            'evento_local_id'=> $this->faker->numberBetween(1, 5), 
        ];
    }
}
