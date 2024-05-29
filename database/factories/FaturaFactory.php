<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fatura>
 */
class FaturaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // 1-aberto / 2-vencido / 3-liquidado / 4-atenção / 5-pgto em atraso
        $status = $this->faker->numberBetween(1, 5);
        $val_fatura = $this->faker->randomFloat(2, 10, 2000);
        $tp_pgto = $this->faker->numberBetween(1, 5);

        $dt_venc = $this->faker->dateTimeBetween('-5 month', 'now');
        $codigo = $dt_venc->format('m/Y');

        if ($status == 3) {
            $valor_pgto = $val_fatura;
            $dt_pgto = $this->faker->dateTimeInInterval($dt_venc, '-2 month');
        }
        if ($status == 5) {
            $valor_pgto = $val_fatura;
            $dt_pgto = $this->faker->dateTimeInInterval($dt_venc, '+2 month');
            $status = 3;
        }
        if ($status == 1) {
            $valor_pgto = 0;
            $dt_pgto = null; //$this->faker->dateTimeInInterval($dt_venc, '-2 month');
            $tp_pgto = null;
        }
        if ($status == 2) {
            $valor_pgto = 0;
            $dt_pgto = null; //$this->faker->dateTimeInInterval($dt_venc, '+2 month');
            $tp_pgto = null;
        }
        if ($status == 4) {
            $valor_pgto = 0;
            $dt_pgto = null; //$this->faker->dateTimeInInterval($dt_venc, '-1 week');
            $tp_pgto = null;
        }

        return [
            'dt_venc' => $dt_venc,
            'dt_pgto' => $dt_pgto,
            'valor_fatura' => $val_fatura,
            'valor_pgto' => $valor_pgto,
            'codigo' => $codigo,
            'notas' => $this->faker->sentence(),

            'fatura_emissora_id' => $this->faker->numberBetween(1, 3),
            'pgto_tipo_id' => $tp_pgto,
            'fatura_status_id' => $status,
        ];
    }
}
