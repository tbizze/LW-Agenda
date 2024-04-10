<?php

namespace App\Livewire\Forms\Evento;

use App\Models\EventoGrupo;
use Livewire\Attributes\Validate;
use Livewire\Form;

class EventoGrupoForm extends Form
{
    public ?EventoGrupo $evento_grupo;

    // Regras de validação.
    #[Validate([
        'nome' => ['required', 'string', 'min:3', 'max:50'],
        'notas' => ['nullable', 'string', 'max:100'],
    ])]

    // Campos da tabela.
    public $nome;
    public $notas;

    // Método p/ popular classe a partir do BD.
    public function setRegistro(EventoGrupo $registro)
    {
        $this->evento_grupo = $registro;
        $this->nome = $registro->nome;
        $this->notas = $registro->notas;
    }

    // Método p/ persistir no BD.
    public function store()
    {
        $this->validate();
        EventoGrupo::create([
            'nome' => $this->nome,
            'notas' => $this->notas,
        ]);
        $this->reset();
    }

    // Método p/ atualizar no BD.
    public function update()
    {
        $this->validate();
        $this->evento_grupo->update([
            'nome' => $this->nome,
            'notas' => $this->notas,
        ]);
        $this->reset();
    }
}
