<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Roda um conjunto de Seeder.
        $this->call([

            //PermissionSeeder::class,
            //UserSeeder::class,

            //EventoAreaSeeder::class,
            //EventoGrupoSeeder::class,
            //EventoLocalSeeder::class,
            //EventoSeeder::class,

            // PgtoTipoSeeder::class,
            // FaturaStatusSeeder::class,

            // Módulo fatura.
            // FaturaGrupoSeeder::class,
            // FaturaEmissoraSeeder::class,
            FaturaSeeder::class,

        ]);
    }
}
