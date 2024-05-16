<?php

namespace App\Livewire\Forms\Recibo;

use App\Models\Recibo;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ReciboForm extends Form
{
    public ?Recibo $objetoForm;

    // Regras de validação.
    #[Validate([
        'valor' => ['required', 'numeric'],
        'data' => ['required', 'date'],
        'historico' => ['required', 'string', 'min:3', 'max:100'],
        'recebedor' => ['required', 'string', 'min:3', 'max:75'],
        'pagador' => ['required', 'string', 'min:3', 'max:75'],
        'cpf_cnpj_receb' => ['nullable', 'string', 'min:11', 'max:20'],
        'cpf_cnpj_pagad' => ['nullable', 'string', 'min:11', 'max:20'],
        'local' => ['required', 'string', 'min:3', 'max:75'],
        //'valor','historico','data','local','pagador','cpf_cnpj_pagad','recebedor','cpf_cnpj_receb',
    ])]

    // Campos da tabela.
    public $valor;
    public $data;
    public $historico;
    public $recebedor;
    public $pagador;
    public $cpf_cnpj_receb;
    public $cpf_cnpj_pagad;
    public $local;

    // Método p/ popular classe a partir do BD.
    public function setRegistro(Recibo $registro)
    {
        $this->objetoForm = $registro;
        $this->valor = $registro->valor;
        $this->data = isset($registro->data) ? $registro->data->format('Y-m-d') : '';
        $this->historico = $registro->historico;
        $this->recebedor = $registro->recebedor;
        $this->pagador = $registro->pagador;
        $this->cpf_cnpj_receb = $registro->cpfCnpjRecebMask;
        $this->cpf_cnpj_pagad = $registro->cpfCnpjPagadMask;
        $this->local = $registro->local;
        // Limpa as validações da memória, deixando o saco de erros vazio.
        $this->resetValidation();
    }

    // Método p/ persistir no BD.
    public function store()
    {
        // dd('store');
        $this->validate();
        //$x = $this->validate();
        //dd($x);
        Recibo::create([
            'valor' => $this->valor,
            'data' => $this->data,
            'historico' => $this->historico,
            'recebedor' => $this->recebedor,
            'pagador' => $this->pagador,
            'cpf_cnpj_receb' => $this->cpf_cnpj_receb,
            'cpf_cnpj_pagad' => $this->cpf_cnpj_pagad,
            'local' => $this->local,
        ]);
        $this->reset();
    }

    // Método p/ atualizar no BD.
    public function update()
    {
        // dd('update');
        $x = $this->validate();
        dd($x);
        $this->validate();
        $this->objetoForm->update([
            $this->all()
        ]);
        $this->reset();
    }
}
