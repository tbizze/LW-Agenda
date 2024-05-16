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
        'nome','notas','start_date','end_date','start_time','end_time','evento_grupo_id','evento_local_id','all_day'
    ];

    /**
     * Configura o formato da data p/ as colunas 'dt_lcto'.
    */
    protected $casts = [
        'start_date' => 'date:d/m/Y',
        'end_date' => 'date:d/m/Y',
        'start_time' => 'date:H:i',
        'end_time' => 'date:H:i',
        'all_day' => 'boolean',
    ];

    /**
     * Cria uma nova propriedade que é acrescentada às diretas do BD.
     * É passado em um array os nomes das propriedades desejadas.
    */
    protected $appends = [
        'mes_nome','mes_numero','dia_numero','dia_nome'
        //'start_date_full', 'start_date_full', //'all_day' 'dia_semana'
    ];

    /* protected function allDay(): Attribute
    {
        return Attribute::make(
            get: fn () => !$this->start_time ? true : false, 
        );
    } */
    protected function startDateFull(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::parse($this->start_date)->format('Y-m-d') . ' ' . Carbon::parse($this->start_time)->format('H:i:s'),  //shortDayName  ou monthName
        );
    }
    protected function endDateFull(): Attribute
    {
        // Se 'end_date' é passado
        if (isset($this->end_date)) {
            // Se 'end_time' é passado, define '$end_date' como junção de 'end_date' + 'end_time'
            if (isset($this->end_time)) {
                $end_date = $this->end_date->format('Y-m-d') . ' ' . $this->end_time->format('H:i:s');
            
            // Se 'end_time' é nulo, define '$end_date' como 'end_date' somente.
            }else{
                $end_date = $this->end_date->format('Y-m-d');
            }
        // Se 'end_date' é nulo, define '$end_date' como null.
        } else {
            $end_date = null;
        }
        return Attribute::make(
            get: fn () => $end_date,  //shortDayName  ou monthName
        );
    }
    protected function diaNumero(): Attribute
    {
        return Attribute::make(
            get: fn () => ucfirst(Carbon::parse($this->start_date)->format('d')),
        );
    }
    protected function diaNome(): Attribute
    {
        return Attribute::make(
            get: fn () => ucfirst(Carbon::parse($this->start_date)->locale('pt')->shortDayName),  //shortDayName  ou dayName
        );
    }
    protected function mesNome(): Attribute
    {
        return Attribute::make(
            get: fn () => ucfirst(Carbon::parse($this->start_date)->locale('pt')->monthName),  //shortDayName  ou monthName
        );
    }
    protected function mesNumero(): Attribute
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
