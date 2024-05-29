<?php

namespace Database\Seeders;

use App\Models\FaturaStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaturaStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $items = [
            [
                'nome' => 'Aberto',
                'notas' => 'To discuss politics'
            ],
            [
                'nome' => 'Vencido',
                'notas' => 'To discuss news and world events'
            ],
            [
                'nome' => 'Liquidado',
                'notas' => 'To discuss cooking and food'
            ],
            [
                'nome' => "Atenção",
                'notas' => 'To discuss politics'
            ]
        ];

        foreach ($items as $item) {
            FaturaStatus::create($item);
        }
    }
}
