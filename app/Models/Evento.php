<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evento extends Model
{
    use HasFactory;

    /**
     * Habilita o recurso de apagar para Lixeira.
     */
    use SoftDeletes;

    /**
     * Lista des campos em que é permitido a persistência no BD.. 
     */
    protected $fillable = [
        'nome','notas','start_date','end_date','start_time','end_time','evento_grupo_id','evento_local_id'
    ];

    /**
     * Configura o formato da data p/ as colunas 'dt_lcto'.
    */
    protected $casts = [
        'start_date' => 'date:d/m/Y',
        'end_date' => 'date:d/m/Y',
        'start_time' => 'date:H:i',
        'end_time' => 'date:H:i',
    ];

    /**
     * RELACIONAMENTO: O Evento 'pertence a um' EventoGrupo. 
     * Obtenha esse registro.
     */
    public function toGrupo(): BelongsTo
    {
        return $this->belongsTo(EventoGrupo::class,'evento_grupo_id')
            ->withDefault(['nome' => 'N/D']);
    }

    /**
     * RELACIONAMENTO: O Evento 'pertence a um' EventoLocal. 
     * Obtenha esse registro.
     */
    public function toLocal(): BelongsTo
    {
        return $this->belongsTo(EventoLocal::class,'evento_local_id')
            ->withDefault(['nome' => 'N/D']);
    }
    
    /**
     * RELACIONAMENTO: Os Eventos 'pertencem a várias' EventoArea. 
     * Obtenha esses registros.
     */
    public function areas(): BelongsToMany
    {
        return $this->belongsToMany(EventoArea::class,'eventos_areas_pivot','evento_id','evento_area_id')
            //->whereNull('areas_eventos_pivot.deleted_at')
            //->withPivot(['deleted_at'])
            ->withTimestamps();
    }
}
