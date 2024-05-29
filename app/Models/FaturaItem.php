<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FaturaItem extends Model
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
        'dt_compra', 'valor_compra', 'historico', 'parcelas', 'notas', 'fatura_id', 'fatura_grupo_id',
    ];

    /**
     * Define colunas c/ datas p/ usar Carbon. 
     */
    protected $casts = [
        'dt_compra' => 'date:d/m/Y',
    ];

    /**
     * RELACIONAMENTO: O Item de Fatura 'pertence a um' FaturaGrupo. 
     * Obtenha esse registro.
     */
    public function toFaturaGrupo(): BelongsTo
    {
        return $this->belongsTo(FaturaGrupo::class, 'fatura_grupo_id');
    }

    /**
     * RELACIONAMENTO: O Item de Fatura 'pertence a uma' Fatura. 
     * Obtenha esse registro.
     */
    public function toFatura(): BelongsTo
    {
        return $this->belongsTo(Fatura::class, 'fatura_id');
    }
}
