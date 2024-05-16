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
        Schema::create('recibos', function (Blueprint $table) {
            $table->id();
            $table->decimal('valor');
            $table->string('historico', 130);
            $table->date('data');
            $table->string('local', 130);
            $table->string('pagador', 130);
            $table->string('cpf_cnpj_pagad', 14)->nullable();
            $table->string('recebedor', 130)->nullable();
            $table->string('cpf_cnpj_receb', 14)->nullable();

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
        Schema::dropIfExists('recibos');
    }
};
