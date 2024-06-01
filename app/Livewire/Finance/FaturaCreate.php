<?php

namespace App\Livewire\Finance;

use App\Livewire\Forms\Finance\FaturaCreateForm;
use Livewire\Attributes\Title;
use Livewire\Component;

class FaturaCreate extends Component
{
    public $page_title = 'Criar Fatura';
    public bool $registroEdit = false;
    public int $registroId;

    // Classe ObjectForm.
    public FaturaCreateForm $objectForm;

    /* Renderiza componente */
    #[Title('Criar Fatura')]
    public function render()
    {
        return view('livewire.finance.fatura-create');
    }
}
