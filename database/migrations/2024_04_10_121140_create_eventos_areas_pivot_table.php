<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('eventos_areas_pivot', function (Blueprint $table) {
            $table->id();
            // Chave estrangeira: Eventos.
            $table->foreignId('evento_id')->references('id')->on('eventos');
            // Chave estrangeira: Áreas de eventos.
            $table->foreignId('evento_area_id')->references('id')->on('evento_areas');
            // Data de criação e de edição.
            $table->timestamps();
            // Recurso SoftDelete = excluir p/ lixeira.
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove a chave estrangeira
        Schema::table('eventos_areas_pivot', function (Blueprint $table) {
            $table->dropForeign(['evento_id']);
            $table->dropForeign(['evento_area_id']);
        });

        Schema::dropIfExists('eventos_areas_pivot');
    }
};
