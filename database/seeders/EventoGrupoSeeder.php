<?php

namespace Database\Seeders;

use App\Models\EventoGrupo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventoGrupoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            // Organismos de coordenação.
            [
                'nome' => 'CAEP',
                'notas' => 'Conselho Assuntos Econômicos.'
            ],
            [
                'nome' => 'CCP',
                'notas' => 'Conselho Comunitário Pastoral'
            ],
            [
                'nome' => 'CPP',
                'notas' => 'Conselho Paroquial Pastoral'
            ],
            [
                'nome' => 'Celebrações',
                'notas' => 'Celebrações nas comunidades'
            ],
            //Pastorais e movimentos.
            [
                'nome' => 'Batismo',
                'notas' => 'Pastoral.'
            ],
            [
                'nome' => 'MESC',
                'notas' => 'Pastoral.'
            ],
            [
                'nome' => 'Liturgia',
                'notas' => 'Pastoral.'
            ],
            [
                'nome' => 'Setor missionário',
                'notas' => 'Pastoral.'
            ],
            [
                'nome' => 'Social',
                'notas' => 'Pastoral.'
            ],
            [
                'nome' => 'Mães que oram',
                'notas' => 'Movimento.'
            ],
            [
                'nome' => 'Apostolado',
                'notas' => 'Movimento.'
            ],
            [
                'nome' => 'Terço homens',
                'notas' => 'Movimento.'
            ],
            [
                'nome' => 'Acólitos',
                'notas' => 'Pastoral.'
            ],
            [
                'nome' => 'Dízimo',
                'notas' => 'Pastoral.'
            ],
            [
                'nome' => 'Música',
                'notas' => 'Pastoral.'
            ],
            [
                'nome' => 'Acolhida',
                'notas' => 'Pastoral.'
            ],
            [
                'nome' => 'Campanha Nova matriz',
                'notas' => 'Ministério.'
            ],
            [
                'nome' => 'Catequese',
                'notas' => 'Pastoral.'
            ],
            [
                'nome' => 'Eventos',
                'notas' => 'Eventos.'
            ],
        ];

        foreach ($items as $item) {
            EventoGrupo::create($item);
        }
    }
}
