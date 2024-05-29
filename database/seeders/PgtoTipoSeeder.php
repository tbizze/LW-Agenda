<?php

namespace Database\Seeders;

use App\Models\PgtoTipo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PgtoTipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $items = [
            [
                'nome' => 'Dinheiro',
                'notas' => 'To discuss politics'
            ],
            [
                'nome' => 'CEF Tiago',
                'notas' => 'To discuss news and world events'
            ],
            [
                'nome' => 'Nubank Tiago',
                'notas' => 'To discuss cooking and food'
            ],
            [
                'nome' => "Bradesco Eli",
                'notas' => 'To discuss politics'
            ],
            [
                'nome' => "Mercantil Eli",
                'notas' => 'To discuss politics'
            ]
        ];

        foreach ($items as $item) {
            PgtoTipo::create($item);
        }
    }
}
