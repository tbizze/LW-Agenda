<?php

namespace App\Livewire\Finance;

use App\Livewire\Forms\Finance\FaturaCreateForm;
use App\Models\FaturaEmissora;
use App\Models\FaturaGrupo;
use App\Models\FaturaStatus;
use App\Models\PgtoTipo;
use Livewire\Attributes\Title;
use Livewire\Component;

class FaturaCreate extends Component
{
    public $page_title = 'Criar Fatura';
    public bool $registroEdit = false;
    public int $registroId;

    public $items;
    public $i;



    // Classe ObjectForm.
    public FaturaCreateForm $objectForm;

    public function mount()
    {
        $this->items = [];
        $this->i = 1;

        $this->objectForm->dt_compra = [];
        $this->objectForm->valor_compra = [];
        $this->objectForm->historico = [];
        $this->objectForm->parcela = [];
        //$this->objectForm->notas=[];
        $this->objectForm->fatura_id = [];
        $this->objectForm->fatura_grupo_id = [];
    }
    public function addItem($i)
    {
        $this->i++;
        array_push($this->items, $i);
    }
    public function removeItem($key)
    {
        //$this->i--;
        unset($this->items[$key]);
        //dd($this->items, $key);
    }

    /* Renderiza componente */
    #[Title('Criar Fatura')]
    public function render()
    {
        return view('livewire.finance.fatura-create', [
            'fatura_grupos' => FaturaGrupo::get(['id', 'nome as name']),
            'fatura_emissoras' => FaturaEmissora::get(['id', 'nome as name']),
            'pgto_tipos' => PgtoTipo::get(['id', 'nome as name']),
            'fatura_statuses' => FaturaStatus::get(['id', 'nome as name']),
        ]);
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
}
