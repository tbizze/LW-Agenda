<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventoArea extends Model
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
        'nome','notas','ativo',
    ];

    /**
     * RELACIONAMENTO: Os EventoArea 'pertencem a várias' Eventos. 
     * Obtenha esses registros.
     */
    public function areas(): BelongsToMany
    {
        return $this->belongsToMany(Evento::class,'eventos_areas_pivot','evento_id','evento_area_id')
            //->whereNull('areas_eventos_pivot.deleted_at')
            //->withPivot(['deleted_at'])
            ->withTimestamps();
    }
}
