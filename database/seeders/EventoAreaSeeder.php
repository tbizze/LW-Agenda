<?php

namespace Database\Seeders;

use App\Models\EventoArea;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventoAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'nome' => 'Diocese',
                'notas' => 'Abrangência diocesana.'
            ],
            [
                'nome' => 'Paroquia',
                'notas' => 'Abrangência paroquial.'
            ],
            [
                'nome' => 'MSJ',
                'notas' => 'Abrangência Comunidade São José.'
            ],
            [
                'nome' => 'NSA',
                'notas' => 'Abrangência Comunidade Aparecida.'
            ],
            [
                'nome' => 'SST',
                'notas' => 'Abrangência Comunidade Trindade.'
            ],
            [
                'nome' => 'CDP',
                'notas' => 'Abrangência CDP.'
            ],
            [
                'nome' => 'Padre',
                'notas' => 'Atividade do padre.'
            ],
        ];

        foreach ($items as $item) {
            EventoArea::create($item);
        }
    }
}
