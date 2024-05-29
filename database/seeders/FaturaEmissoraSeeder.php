<?php

namespace Database\Seeders;

use App\Models\FaturaEmissora;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaturaEmissoraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $items = [
            [
                'nome' => 'Bradesco',
                'notas' => 'To discuss politics'
            ],
            [
                'nome' => 'Credicard',
                'notas' => 'To discuss news and world events'
            ],
            [
                'nome' => 'Nubank',
                'notas' => 'To discuss cooking and food'
            ]
        ];

        foreach ($items as $item) {
            FaturaEmissora::create($item);
        }
    }
}
