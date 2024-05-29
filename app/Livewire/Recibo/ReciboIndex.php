<?php

namespace App\Livewire\Recibo;

use App\Models\Recibo;
use App\Rules\CpfOrCnpj;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ReciboIndex extends Component
{
    use Toast;
    use WithPagination;

    // Modelo.
    public ?Recibo $objectForm = null;

    // Propriedades (campos) do modelo.
    public $valor = '';
    public $data = '';
    public $historico = '';
    public $recebedor = '';
    public $pagador = '';
    public $cpf_cnpj_receb = '';
    public $cpf_cnpj_pagad = '';
    public $local = '';

    // Regras de validação.
    #[Validate([
        'valor' => ['required', 'numeric'],
        'data' => ['required', 'date'],
        'historico' => ['required', 'string', 'min:3', 'max:100'],
        'recebedor' => ['required', 'string', 'min:3', 'max:75'],
        'pagador' => ['required', 'string', 'min:3', 'max:75'],
        'cpf_cnpj_receb' => ['nullable', 'string', 'min:11', 'max:18', new CpfOrCnpj],
        'cpf_cnpj_pagad' => ['nullable', 'string', 'min:11', 'max:18', new CpfOrCnpj],
        'local' => ['required', 'string', 'min:3', 'max:75'],
        //'valor','historico','data','local','pagador','cpf_cnpj_pagad','recebedor','cpf_cnpj_receb',
    ])]

    public array $sortBy = ['column' => 'historico', 'direction' => 'asc'];
    public string $search = '';

    public bool $modalRegistro = false;
    public bool $modalConfirmDelete = false;
    public bool $registroEditMode = false;

    public $registro_id = '';
    public $page_title = 'Recibos';
    public $date_config = ['altFormat' => 'd/m/Y'];

    public function mount(Recibo $registro): void
    {
        if ($registro->exists) {
            //dump(currency_to_db($registro->valor));
            $this->valor = currency_to_db($registro->valor);
            $this->data = isset($registro->data) ? $registro->data->format('Y-m-d') : '';
            $this->historico = $registro->historico;
            $this->recebedor = $registro->recebedor;
            $this->pagador = $registro->pagador;
            $this->cpf_cnpj_receb = $registro->cpfCnpjRecebMask;
            $this->cpf_cnpj_pagad = $registro->cpfCnpjPagadMask;
            $this->local = $registro->local;
            // Limpa as validações da memória, deixando a bag de erros vazia.
            $this->resetValidation();
        }
    }

    /* Renderiza componente */
    #[Title('Recibos')]
    public function render()
    {
        return view('livewire.recibo.recibo-index', [
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
    public function showModalRegistro($id = null, $copy = false)
    {
        //dd($id);
        if ($id) {

            // Busca dados do modelo no BD.
            $this->objectForm = Recibo::findOrFail($id);
            // Carrega inputs do formulário com o modelo preparado.
            $this->mount($this->objectForm);
            // Define o tipo de formulário: true=edit, false=create. 
            if (!$copy) {
                $this->registroEditMode = true;
            }
            // Torna o modal visível.
            $this->modalRegistro = true;
        } else {
            // Limpa os inputs do formulário.
            $this->reset(
                'valor',
                'historico',
                'data',
                'local',
                'pagador',
                'cpf_cnpj_pagad',
                'recebedor',
                'cpf_cnpj_receb',
            );
            // Torna o modal visível.
            $this->modalRegistro = true;
        }
    }
    // Método p/ carregar inputs do form.
    // Mas não carrega o modelo, para que ao salvar faça STORE()
    // Por isso registroEditMode = false
    public function copyRecord($id)
    {
        // Busca dados do modelo no BD.
        $this->objectForm = Recibo::findOrFail($id);
        // Carrega inputs do formulário com o modelo preparado.
        $this->mount($this->objectForm);
        // Define o tipo de formulário: true=edit, false=create. 
        $this->registroEditMode = false;
        // Torna o modal visível.
        $this->modalRegistro = true;
    }

    /*
    |--------------------------------------------------------------------------
    | MÉTODOS COM REGISTROS
    |--------------------------------------------------------------------------
    | Ações de salvar, chamar o delete, confirmar o delete
    */

    public function submitForm()
    {
        //TODO: antes do validate, implement limpar máscara.
        //dd($this->all());
        //dump('antes validate');
        //dd($this->cpf_cnpj_pagad, $this->cpf_cnpj_receb);
        $this->validate();
        //dd($this->all());
        $this->sanitize();

        // UPDATE: Como existe o objectForm, e registroEditMode = TRUE, então salva alterações.
        if (!is_null($this->objectForm) && $this->registroEditMode == true) {
            $this->objectForm->update(
                $this->only(['valor', 'historico', 'data', 'local', 'pagador', 'cpf_cnpj_pagad', 'recebedor', 'cpf_cnpj_receb'])
            );
            // Emite mensagem de sucesso.
            $this->success('Registro salvo com sucesso!');

            // CREATE: objectForm = NULL, e registroEditMode = FALSE, então cria novo registro.
        } else {
            Recibo::create(
                $this->only(['valor', 'historico', 'data', 'local', 'pagador', 'cpf_cnpj_pagad', 'recebedor', 'cpf_cnpj_receb'])
            );
            // Emite mensagem de sucesso.
            $this->success('Registro incluído com sucesso!');
        }

        // Oculta modal.
        $this->modalRegistro = false;
    }

    // Método p/ carregar inputs do form e exibir modal.
    // public function edit(Recibo $registro)
    // {
    //     $this->form->setRegistro($registro);
    //     $this->registroEditMode = true;
    //     $this->modalRegistro = true;
    // }

    // Método p/ salvar: STORE ou UPDATE.
    // public function save()
    // {
    //     // Ação: UPDATE.
    //     if ($this->registroEditMode) {
    //         $this->form->update();
    //         $this->registroEditMode = false;
    //         $this->success('Registro salvo com sucesso!');
    //         // Ação: STORE.
    //     } else {
    //         $this->form->store();
    //         $this->success('Registro incluído com sucesso!');
    //     }
    //     // Oculta modal.
    //     $this->modalRegistro = false;
    // }

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

    //TODO: método para antes da validação, fazer algo.
    // protected function prepareForValidation($attributes)
    // {
    //     $this->merge([
    //         // Transforming the name to have the first letter of each word capitalized
    //         'cpf_cnpj_pagad' => sanitize_number($this->cpf_cnpj_pagad),
    //         'cpf_cnpj_receb' => sanitize_number($this->cpf_cnpj_receb),
    //     ]);
    //     //$this->cpf_cnpj_pagad = sanitize_number($attributes['cpf_cnpj_pagad']);
    //     //$this->cpf_cnpj_receb = sanitize_number($attributes['cpf_cnpj_receb']);
    //     //$attributes['cpf_cnpj_pagad'] = sanitize_number($this->cpf_cnpj_pagad);
    //     //$attributes['cpf_cnpj_receb'] = sanitize_number($this->cpf_cnpj_receb);
    //     //dump('prepareForValidation');
    //     //dd($attributes);
    //     //return $attributes;
    // }
    public function sanitize()
    {
        //dump($this->cpf_cnpj_pagad, $this->cpf_cnpj_receb);
        $this->cpf_cnpj_pagad = sanitize_number($this->cpf_cnpj_pagad);
        $this->cpf_cnpj_receb = sanitize_number($this->cpf_cnpj_receb);
    }
}
