<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
     * Cria uma nova propriedade que é acrescentada às diretas do BD.
     * É passado em um array os nomes das propriedades desejadas.
    */
    protected $appends = [
        'dia_semana','nome_mes','numero_mes','numero_dia',
        'start_date_full', 'all_day'
    ];

    protected function allDay(): Attribute
    {
        return Attribute::make(
            get: fn () => !$this->start_time ? true : false, 
        );
    }
    protected function startDateFull(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::parse($this->start_date)->format('Y-m-d') . ' ' . Carbon::parse($this->start_time)->format('H:i:s'),  //shortDayName  ou monthName
        );
    }
    protected function diaSemana(): Attribute
    {
        return Attribute::make(
            get: fn () => ucfirst(Carbon::parse($this->start_date)->locale('pt')->shortDayName),  //shortDayName  ou dayName
        );
    }
    protected function nomeMes(): Attribute
    {
        return Attribute::make(
            get: fn () => ucfirst(Carbon::parse($this->start_date)->locale('pt')->shortMonthName),  //shortDayName  ou monthName
        );
    }
    protected function numeroMes(): Attribute
    {
        return Attribute::make(
            get: fn () => ucfirst(Carbon::parse($this->start_date)->month),  //shortDayName  ou monthName
        );
    }
    protected function numeroDia(): Attribute
    {
        return Attribute::make(
            get: fn () => ucfirst(Carbon::parse($this->start_date)->format('d/m')),  //shortDayName  ou monthName
        );
    }

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
