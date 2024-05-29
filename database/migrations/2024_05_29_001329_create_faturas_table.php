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
        Schema::create('faturas', function (Blueprint $table) {
            $table->id();
            $table->date('dt_venc');
            $table->date('dt_pgto')->nullable();
            $table->decimal('valor_fatura')->nullable();
            $table->decimal('valor_pgto')->nullable();
            $table->string('codigo')->nullable();
            $table->string('notas')->nullable();
            // Data de criação e de edição.
            $table->timestamps();
            // Recurso SoftDelete = excluir p/ lixeira.
            $table->softDeletes();
            // Chave estrangeira.
            $table->foreignId('fatura_emissora_id')->constrained();
            $table->foreignId('pgto_tipo_id')->nullable()->constrained();
            $table->foreignId('fatura_status_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove a chave estrangeira
        Schema::table('faturas', function (Blueprint $table) {
            $table->dropForeign(['fatura_emissora_id']);
            $table->dropForeign(['pgto_tipo_id']);
            $table->dropForeign(['fatura_status_id']);
        });
        Schema::dropIfExists('faturas');
    }
};
