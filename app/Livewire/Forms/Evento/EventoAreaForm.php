<?php

namespace App\Livewire\Forms\Evento;

use App\Models\EventoArea;
use Livewire\Attributes\Validate;
use Livewire\Form;

class EventoAreaForm extends Form
{
    public ?EventoArea $evento_area;

    // Regras de validação.
    #[Validate([
        'nome' => ['required', 'string', 'min:3', 'max:50'],
        'notas' => ['nullable', 'string', 'max:100'],
    ])]

    // Campos da tabela.
    public $nome;
    public $notas;

    // Método p/ popular classe a partir do BD.
    public function setRegistro(EventoArea $registro)
    {
        $this->evento_area = $registro;
        $this->nome = $registro->nome;
        $this->notas = $registro->notas;
    }

    // Método p/ persistir no BD.
    public function store()
    {
        $this->validate();
        EventoArea::create([
            'nome' => $this->nome,
            'notas' => $this->notas,
        ]);
        $this->reset();
    }

    // Método p/ atualizar no BD.
    public function update()
    {
        $this->validate();
        $this->evento_area->update([
            'nome' => $this->nome,
            'notas' => $this->notas,
        ]);
        $this->reset();
    }
}
