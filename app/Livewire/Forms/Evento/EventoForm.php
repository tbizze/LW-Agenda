<?php

namespace App\Livewire\Forms\Evento;

use App\Models\Evento;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Form;

class EventoForm extends Form
{
    public ?Evento $evento;

    // Regras de validação.
    #[Validate([
        'nome' => ['required', 'string', 'min:3', 'max:50'],
        'notas' => ['nullable', 'string', 'max:100'],
        'start_date' => ['required', 'date'],
        'end_date' => ['nullable', 'date'],
        'start_time' => ['nullable', 'date_format:H:i'],
        'end_time' => ['nullable', 'date_format:H:i'],
        'evento_grupo_id' => ['required', 'numeric'],
    ])]

    // Campos da tabela.
    public $nome;
    public $notas;
    public $start_date;
    public $end_date;
    public $start_time;
    public $end_time;
    public $all_day = false;
    public $evento_grupo_id ='';
    public $evento_local_id;
    public $evento_areas_selected = [];

    // Método p/ popular classe a partir do BD.
    public function setRegistro(Evento $registro)
    {
        $this->evento_areas_selected = [];

        $this->evento = $registro;
        $this->nome = $registro->nome;
        $this->notas = $registro->notas;
        $this->start_date = isset($registro->start_date) ? $registro->start_date->format('Y-m-d') : '';
        $this->end_date = isset($registro->end_date) ? $registro->end_date->format('Y-m-d') : '';
        $this->start_time = isset($registro->start_time) ? $registro->start_time->format('H:i') : null;
        $this->end_time = isset($registro->end_time) ? $registro->end_time->format('H:i') : null;
        $this->all_day = $registro->all_day;
        $this->evento_grupo_id = $registro->evento_grupo_id;
        $this->evento_local_id = $registro->evento_local_id;
        foreach ($registro->areas as $area) {
            $this->evento_areas_selected[] = $area->id;
        }
    }

    // Método p/ persistir no BD.
    public function store()
    {
        if($this->end_date){
            $var_end_date = $this->end_date;
        }else{
            $var_end_date = null;
        }

        DB::transaction(function () use ($var_end_date)  {
            // Carrega no model atual os dados aprovados nas validações, para persistir no DB.
            $this->validate();
            // Persiste o model atualizado no DB.
            $evento = Evento::create([
                'nome' => $this->nome,
                'start_date' => $this->start_date,
                //'end_date' => $this->end_date,
                'end_date' => $var_end_date,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'all_day' => $this->all_day,
                'evento_grupo_id' => $this->evento_grupo_id,
                'evento_local_id' => $this->evento_local_id,
                'notas' => $this->notas,
            ]);
            
            // Salva as áreas na tabela Pivô
            if ($this->evento_areas_selected) {
                $evento->areas()->sync($this->evento_areas_selected);
            }
        });
        $this->reset();
    }

    // Método p/ atualizar no BD.
    public function update()
    {
        //dd($this->all());

        if($this->end_date){
            $var_end_date = $this->end_date;
        }else{
            $var_end_date = null;
        }

        DB::transaction(function () use ($var_end_date)  {
            // Carrega no model atual os dados aprovados nas validações, para persistir no DB.
            $this->validate();
            // Persiste o model atualizado no DB.
            $this->evento->update([
                'nome' => $this->nome,
                'start_date' => $this->start_date,
                //'end_date' => $this->end_date,
                'end_date' => $var_end_date,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'all_day' => $this->all_day,
                'evento_grupo_id' => $this->evento_grupo_id,
                'evento_local_id' => $this->evento_local_id,
                'notas' => $this->notas,
            ]);

            // Salva as áreas na tabela Pivô
            if ($this->evento_areas_selected) {
                $this->evento->areas()->sync($this->evento_areas_selected);
            }
        });
        $this->reset();
    }
}
