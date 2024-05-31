<?php

namespace App\Livewire\Finance;

use App\Models\Fatura;
use Livewire\Attributes\Title;
use Livewire\Component;

class FaturaIndex extends Component
{
    public $page_title = 'Faturas';
    public array $sortBy = ['column' => 'dt_venc', 'direction' => 'asc'];
    public string $search = '';
    public bool $registroEdit = false;
    public int $registroId;

    // Classe ObjectForm.
    //public FaturaEmissoraForm $objectForm;

    /* Renderiza componente */
    #[Title('Faturas')]
    public function render()
    {
        return view('livewire.finance.fatura-index', [
            'headers' => $this->headers(),
            'registros' => $this->dados(),
        ]);
    }

    // Método p/ Cabeçalho da tabela
    public function headers()
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'bg-base-200 w-1'],
            ['key' => 'dt_venc', 'label' => 'Vencimento'],
            ['key' => 'dt_pgto', 'label' => 'Pagamento', 'sortable' => false],
            ['key' => 'valor_fatura', 'label' => 'Valor'],
            ['key' => 'valor_pgto', 'label' => 'Valor Pgto.'],
            ['key' => 'codigo', 'label' => 'Código'],
            ['key' => 'to_fatura_emissora_nome', 'label' => 'Emissora'],
            ['key' => 'to_pgto_tipo_nome', 'label' => 'Tipo pgto.'],
            ['key' => 'to_fatura_status_nome', 'label' => 'Status'],
        ];
        //'dt_venc', 'dt_pgto', 'valor_fatura', 'valor_pgto', 'codigo', 'notas', 'fatura_emissora_id', 'pgto_tipo_id', 'status_id'
    }

    // Método p/ obter dados da tabela
    public function dados()
    {
        return Fatura::query()
            ->withAggregate('toFaturaEmissora', 'nome')
            ->withAggregate('toPgtoTipo', 'nome')
            ->withAggregate('toFaturaStatus', 'nome')
            ->when($this->search, function ($query, $val) {
                $query->where('dt_venc', 'like', '%' . $val . '%');
                //$query->orWhere('notas', 'like', '%' . $val . '%');
                return $query;
            })
            ->orderBy(...array_values($this->sortBy))
            ->paginate(10);
    }
}
