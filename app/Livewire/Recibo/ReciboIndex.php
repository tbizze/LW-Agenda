<?php

namespace App\Livewire\Recibo;

use App\Livewire\Forms\Recibo\ReciboForm;
use App\Models\Recibo;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ReciboIndex extends Component
{
    use Toast;
    use WithPagination;

    public array $sortBy = ['column' => 'historico', 'direction' => 'asc'];
    public string $search = '';

    public bool $modalRegistro = false;
    public bool $modalConfirmDelete = false;
    public bool $registroEditMode = false;

    public ReciboForm $form;
    public $registro_id = '';
    public $page_title = 'Recibos';
    public $date_config = ['altFormat' => 'd/m/Y'];

    /* Renderiza componente */
    #[Title('Recibos')]
    public function render()
    {
        return view('livewire.recibo.recibo-index',[
            'headers' => $this->headers(),
            'recibos' => $this->recibos(),
        ]);
    }

    // Método p/ Cabeçalho da tabela
    public function headers()
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'bg-base-200 w-1'],
            ['key' => 'cpfCnpjRecebMask', 'label' => 'CPF/CNPJ'],
            ['key' => 'recebedor', 'label' => 'Recebedor'],
            ['key' => 'valor', 'label' => 'Valor'],
            ['key' => 'data', 'label' => 'Data'],
            ['key' => 'historico', 'label' => 'Histórico', 'sortable' => false],
            //'valor','historico','data','local','pagador','cpf_cnpj_pagad','recebedor','cpf_cnpj_receb',
        ];
    }

    // Método p/ obter dados da tabela
    public function recibos()
    {
        return Recibo::query()
            ->when($this->search, function ($query, $val) {
                $query->where('historico', 'like', '%' . $val . '%');
                $query->orWhere('recebedor', 'like', '%' . $val . '%');
                return $query;
            })
            ->orderBy(...array_values($this->sortBy))
            ->paginate(10);
    }

    /*
    |--------------------------------------------------------------------------
    | MÉTODOS DE AÇÕES
    |--------------------------------------------------------------------------
    | Ações diversas no componente.
    */

    // Método p/ habilitar modal Edit/Create.
    public function showModalRegistro()
    {
        $this->form->reset();
        $this->modalRegistro = true;
    }

    /*
    |--------------------------------------------------------------------------
    | MÉTODOS COM REGISTROS
    |--------------------------------------------------------------------------
    | Ações de salvar, chamar o delete, confirmar o delete
    */

    // Método p/ carregar inputs do form e exibir modal.
    public function edit(Recibo $registro)
    {
        $this->form->setRegistro($registro);
        $this->registroEditMode = true;
        $this->modalRegistro = true;
    }

    // Método p/ salvar: STORE ou UPDATE.
    public function save()
    {
        // Ação: UPDATE.
        if ($this->registroEditMode) {
            $this->form->update();
            $this->registroEditMode = false;
            $this->success('Registro salvo com sucesso!');
        // Ação: STORE.
        } else {
            $this->form->store();
            $this->success('Registro incluído com sucesso!');
        }
        // Oculta modal.
        $this->modalRegistro = false;
    }

    // Método p/ confirmar delete. Abre modal para confirmação.
    public function confirmDelete($id)
    {
        $this->registro_id = $id;
        $this->modalConfirmDelete = true;
    }

    // Método para deletar.
    public function delete($id)
    {
        Recibo::find($id)->delete();
        $this->modalConfirmDelete = false;
        $this->success('Registro excluído com sucesso!');
    }
}
