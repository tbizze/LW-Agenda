<?php

namespace App\Livewire\Finance;

use App\Livewire\Forms\Finance\FaturaEmissoraForm;
use App\Models\FaturaEmissora;
use Livewire\Attributes\Title;
use Livewire\Component;

class FaturaEmissoraIndex extends Component
{
    public $page_title = 'Emissoras de Fatura';
    public array $sortBy = ['column' => 'nome', 'direction' => 'asc'];
    public string $search = '';
    public bool $registroEdit = false;
    public int $registroId;

    // Classe ObjectForm.
    public FaturaEmissoraForm $objectForm;

    /* Renderiza componente */
    #[Title('Emissoras de Fatura')]
    public function render()
    {
        return view('livewire.finance.fatura-emissora-index', [
            'headers' => $this->headers(),
            'registros' => $this->dados(),
        ]);
    }

    // Método p/ Cabeçalho da tabela
    public function headers()
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'bg-base-200 w-1'],
            ['key' => 'nome', 'label' => 'Nome'],
            ['key' => 'notas', 'label' => 'Notas', 'sortable' => false],
            ['key' => 'ativo', 'label' => 'Ativo'],
        ];
    }

    // Método p/ obter dados da tabela
    public function dados()
    {
        return FaturaEmissora::query()
            ->when($this->search, function ($query, $val) {
                $query->where('nome', 'like', '%' . $val . '%');
                $query->orWhere('notas', 'like', '%' . $val . '%');
                return $query;
            })
            ->orderBy(...array_values($this->sortBy))
            ->paginate(10);
    }

    // Abrir Modal criar/editar.
    public function openModal($id = null)
    {
        $this->resetValidation();
        if ($id) {
            // ClassForm Edit: Método p/ preencher formulário com dados do BD.
            $this->objectForm->edit($id);
            $this->registroEdit = true;
            $this->registroId = $id;
        } else {
            // ClassForm Create: Método p/ abrir formulário vazio.
            $this->objectForm->create();
            $this->registroEdit = false;
        }
    }

    // Abrir Modal criar/editar ==> como cópia.
    public function copyRecord($id)
    {
        $this->resetValidation();
        $this->objectForm->copy($id);
        $this->registroEdit = false;
    }

    // Método p/ submeter formulário.
    public function submitForm()
    {
        if ($this->registroEdit) {
            // ClassForm Update: Método p/ atualizar dados no BD.
            $this->objectForm->update();
        } else {
            // ClassForm Store: Método p/ criar dados no BD.
            $this->objectForm->store();
        }
    }

    // Abrir modal de confirmação de delete.
    public function confirmDelete($id)
    {
        $this->registroId = $id;
        $this->objectForm->modalConfirmDelete = true;
    }

    // Método p/ deletar registro depois de confirmado.
    public function delete($id)
    {
        $this->objectForm->destroy($id);
    }
}
