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
        Schema::create('fatura_items', function (Blueprint $table) {
            $table->id();
            $table->date('dt_compra');
            $table->decimal('valor_compra');
            $table->string('historico');
            $table->string('parcela')->nullable();
            $table->string('notas')->nullable();

            // Data de criação e de edição.
            $table->timestamps();
            // Recurso SoftDelete = excluir p/ lixeira.
            $table->softDeletes();

            // Chave estrangeira.
            $table->foreignId('fatura_id')->constrained();
            $table->foreignId('fatura_grupo_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove a chave estrangeira
        Schema::table('fatura_items', function (Blueprint $table) {
            $table->dropForeign(['fatura_id']);
            $table->dropForeign(['fatura_grupo_id']);
        });
        Schema::dropIfExists('fatura_items');
    }
};
