<?php

namespace Database\Seeders;

use App\Models\EventoLocal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventoLocalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'nome' => 'Diocese',
                'notas' => 'Realizado na diocese.'
            ],
            [
                'nome' => 'MSJ',
                'notas' => 'Realizado na matriz.'
            ],
            [
                'nome' => 'NSA',
                'notas' => 'Realizado na NSA.'
            ],
            [
                'nome' => 'SST',
                'notas' => 'Realizado na SST.'
            ],
            [
                'nome' => 'Lar Idosos',
                'notas' => 'Realizado na instituição.'
            ],
            [
                'nome' => 'Outros',
                'notas' => 'Realizado externamente.'
            ],
        ];

        foreach ($items as $item) {
            EventoLocal::create($item);
        }
    }
}
