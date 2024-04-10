<?php

namespace App\Livewire\Forms\Evento;

use App\Models\Evento;
use Livewire\Attributes\Validate;
use Livewire\Form;

class EventoForm extends Form
{
    public ?Evento $evento;

    // Regras de validação.
    #[Validate([
        'nome' => ['required', 'string', 'min:3', 'max:50'],
        'notas' => ['nullable', 'string', 'max:100'],
    ])]

    // Campos da tabela.
    public $nome;
    public $notas;
    public $start_date;
    public $end_date;
    public $start_time;
    public $end_time;
    public $evento_grupo_id;
    public $evento_local_id;

    // Método p/ popular classe a partir do BD.
    public function setRegistro(Evento $registro)
    {
        $this->evento = $registro;
        $this->nome = $registro->nome;
        $this->notas = $registro->notas;
        $this->start_date = $registro->start_date->format('Y-m-d');
        $this->end_date = $registro->end_date->format('Y-m-d');
        $this->start_time = isset($registro->start_time) ? $registro->start_time->format('H:i') : null;
        $this->end_time = isset($registro->end_time) ? $registro->end_time->format('H:i') : null;
        $this->evento_grupo_id = $registro->evento_grupo_id;
        $this->evento_local_id = $registro->evento_local_id;
    }

    // Método p/ persistir no BD.
    public function store()
    {
        $this->validate();
        Evento::create([
            'nome' => $this->nome,
            'notas' => $this->notas,
        ]);
        $this->reset();
    }

    // Método p/ atualizar no BD.
    public function update()
    {
        $this->validate();
        $this->evento->update([
            'nome' => $this->nome,
            'notas' => $this->notas,
        ]);
        $this->reset();
    }
}
