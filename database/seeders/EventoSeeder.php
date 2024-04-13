<?php

namespace Database\Seeders;

use App\Models\Evento;
use App\Models\EventoArea;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cria Eventos usando a 'Factories'
        //\App\Models\Evento::factory(2)->create();

        /* Evento::factory()
            ->count(3)
            //->hasFaturaItems(2) // create two records/contact of each company
            ->has(FaturaItem::factory()->count(2), 'hasFaturaItens') // create two records/contact of each company
            ->create(); */
        //$area = collect(EventoArea::pluck('id'));
        /* dd($news->random());
        
        $a=array("a"=>"red","b"=>"green","c"=>"blue","d"=>"yellow");
        //$a=array($news);
        dd(array_rand($a,2)); */

        $eventos = Evento::factory(50)
        ->create()
        ->each(function ($evento) {
            //$news = (EventoArea::)->create();
            /* $news = EventoArea::pluck('id');
            dd($news); */
            $area = collect(EventoArea::pluck('id'));
            $evento->areas()->sync($area->random());
        });
    }
}


