<?php

namespace Database\Seeders;

use App\Models\FaturaGrupo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaturaGrupoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $items = [
            [
                'nome' => 'Paróquia',
                'notas' => 'To discuss politics'
            ],
            [
                'nome' => 'CSMP',
                'notas' => 'To discuss news and world events'
            ],
            [
                'nome' => 'CDP',
                'notas' => 'To discuss cooking and food'
            ],
            [
                'nome' => "Casa Paroquial",
                'notas' => 'To discuss politics'
            ]
        ];

        foreach ($items as $item) {
            FaturaGrupo::create($item);
        }
    }
}
