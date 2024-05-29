<?php

namespace Database\Seeders;

use App\Models\Fatura;
use App\Models\FaturaItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaturaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //$fatura = Fatura::factory(10)->create();
        Fatura::factory()
            ->count(3)
            //->hasFaturaItems(2) // create two records/contact of each company
            ->has(FaturaItem::factory()->count(2), 'hasFaturaItens') // create two records/contact of each company
            ->create();
    }
}
