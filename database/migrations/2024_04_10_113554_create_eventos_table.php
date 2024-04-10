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
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('notas')->nullable();

            // Chave estrangeira: Grupo.
            $table->foreignId('evento_grupo_id')->nullable()->constrained('evento_grupos');
            // Chave estrangeira: Local.
            $table->foreignId('evento_local_id')->nullable()->constrained('evento_locals');

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
        Schema::table('eventos', function (Blueprint $table) {
            $table->dropForeign(['evento_grupo_id']);
            $table->dropForeign(['evento_local_id']);
        });

        Schema::dropIfExists('eventos');
    }
};
