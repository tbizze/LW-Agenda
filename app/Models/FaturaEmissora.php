<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class FaturaEmissora extends Model
{
    use HasFactory;

    /**
     * Habilita o recurso de excluir para Lixeira.
     */
    use SoftDeletes;

    /**
     * Lista de campos com persistência no BD. 
     */
    protected $fillable = [
        'nome', 'notas', 'ativo'
    ];

    /**
     * Configura o formato da data p/ as colunas 'dt_lcto'.
     */
    protected $casts = [
        'ativo' => 'boolean',
    ];

    /**
     * RELACIONAMENTO: A Emissora 'tem muitas' (hasMany) Faturas. 
     * Obtenha essa coleção de registros.
     */
    public function hasFaturas(): HasMany
    {
        return $this->hasMany(Fatura::class);
    }
}
