<?php

namespace App\Livewire\Forms\Finance;

use App\Models\FaturaEmissora;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FaturaEmissoraForm extends Form
{
    public ?FaturaEmissora $form;
    //public $faturaEmissoraId = '';
    public $modalRegistro = false;
    public $modalConfirmDelete = false;

    #[Rule('required|string|min:3|max:50')]
    public $nome;
    public $notas;
    #[Rule('boolean')]
    public $ativo;

    public function copy($id)
    {
        $registro = FaturaEmissora::findOrFail($id);

        $this->nome = $registro->nome;
        $this->notas = $registro->notas;
        $this->ativo = $registro->ativo;
        $this->modalRegistro = true;
    }

    public function create()
    {
        $this->reset();
        $this->modalRegistro = true;
    }

    public function store()
    {
        // O recurso is_bool checa se boolean, transformando null p/ false.
        // Necessário, já que na criação, toggle false passa valor null.
        $this->ativo = is_bool($this->ativo);

        $this->validate();
        FaturaEmissora::create(
            $this->only('nome', 'notas', 'ativo')
        );
        $this->reset();
    }

    public function edit($id)
    {
        $registro = FaturaEmissora::findOrFail($id);
        $this->form = $registro;

        $this->nome = $registro->nome;
        $this->notas = $registro->notas;
        $this->ativo = $registro->ativo;
        $this->modalRegistro = true;
    }

    public function update()
    {
        $this->validate();
        $this->validate();
        $this->form->update(
            $this->only('nome', 'notas', 'ativo')
        );
        $this->reset();
    }

    // Método para deletar.
    public function destroy($id)
    {
        FaturaEmissora::findOrFail($id)->delete();
        $this->reset();
        //$this->success('Registro excluído com sucesso!');
    }
}
