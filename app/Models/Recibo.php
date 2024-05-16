<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recibo extends Model
{
    use HasFactory;

    /**
     * Habilita o recurso de apagar para Lixeira.
     */
    use SoftDeletes;

    /**
     * Lista de campos em que é permitido a persistência no BD.
     */
    protected $fillable = [
        'valor','historico','data','local','pagador','cpf_cnpj_pagad','recebedor','cpf_cnpj_receb',
    ];

    /**
     * Configura o formato da data.
    */
    protected $casts = [
        'data' => 'date:d/m/Y',
    ];


    /**
     * Cria uma nova propriedade que é acrescentada às diretas do BD.
     * É passado em um array os nomes das propriedades desejadas.
    */
    protected $appends = [
        'cpf_cnpj_pagad_mask','cpf_cnpj_receb_mask','valor_extenso'
    ];

    protected function cpfCnpjPagadMask(): Attribute
    {
        return Attribute::make(
            get: fn () => mask_cpf_cnpj($this->cpf_cnpj_pagad), 
        );
    }
    protected function cpfCnpjRecebMask(): Attribute
    {
        return Attribute::make(
            get: fn () => mask_cpf_cnpj($this->cpf_cnpj_receb), 
        );
    }
    protected function valorExtenso(): Attribute
    {
        return Attribute::make(
            get: fn () => currency_extenso(currency_to_db($this->valor)), 
        );
    }

    protected function valor(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => currency_get_db($value),
        );
    }
    protected function cpf_cnpj_pagad(): Attribute
    {
        return Attribute::make(
            //get: fn (string $value) => currency_get_db($value),
            set: fn (string $value) => sanitize_number($value),
        );
    }
}
