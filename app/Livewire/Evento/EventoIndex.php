<?php

namespace App\Livewire\Evento;

use App\Livewire\Forms\Evento\EventoForm;
use App\Models\Evento;
use App\Models\EventoGrupo;
use App\Models\EventoLocal;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class EventoIndex extends Component
{
    use Toast;
    use WithPagination;

    public array $sortBy = ['column' => 'start_date', 'direction' => 'asc'];
    public string $search = '';

    public bool $modalRegistro = false;
    public bool $modalConfirmDelete = false;
    public bool $registroEditMode = false;
    public bool $showDrawer = false;

    public EventoForm $form;
    public $registro_id = '';
    public $qdeFilter = 0;
    public $page_title = 'Eventos';
    public $date_config = ['altFormat' => 'd/m/Y'];
    /* Campos de filtros */
    public $date_init = '';
    public $date_end = '';
    public $fil_grupo = '';
    public $fil_local = '';
    //public $fil_tipo = '';

    /* Renderiza componente */
    #[Title('Eventos')]
    public function render()
    {
        return view('livewire.evento.evento-index',[
            'headers' => $this->headers(),
            'eventos' => $this->eventos(),
            'evento_locals' => EventoLocal::orderBy('nome')->get(['id', 'nome as name']),
            'evento_grupos' => EventoGrupo::orderBy('nome')->get(['id', 'nome as name']),
        ]);
    }

    // Método p/ obter dados da tabela
    public function eventos()
    {
        return Evento::query()
            ->withAggregate('toGrupo', 'nome')
            ->withAggregate('toLocal', 'nome')
            ->when($this->search, function ($query, $val) {
                $query->where('nome', 'like', '%' . $val . '%');
                $query->orWhere('notas', 'like', '%' . $val . '%');
                return $query;
            })
            ->when($this->fil_grupo, function ($query, $val) {
                $query->where('evento_grupo_id', $val);
                return $query;
            })
            ->when($this->fil_local, function ($query, $val) {
                $query->where('evento_local_id', $val);
                return $query;
            })
            ->when($this->date_init, function ($query, $val) {
                $query->whereBetween('start_date', [$this->date_init, $this->date_end]);
                return $query;
            })
            ->orderBy(...array_values($this->sortBy))
            ->paginate(10);
    }

    //'nome','notas','start_date','end_date','start_time','end_time','evento_grupo_id','evento_local_id'

    //* Método p/ Cabeçalho da tabela
    public function headers()
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'bg-base-200 w-1'],
            ['key' => 'start_date', 'label' => 'Data início'],
            ['key' => 'start_time', 'label' => 'Hora início'],
            ['key' => 'nome', 'label' => 'Nome'],
            ['key' => 'to_grupo_nome', 'label' => 'Grupo'],
            ['key' => 'to_local_nome', 'label' => 'Local'],
            ['key' => 'notas', 'label' => 'Notas', 'sortable' => false],
        ];
    }

    // Método p/ habilitar modal Edit/Create.
    public function showModalRegistro()
    {
        $this->form->reset();
        $this->modalRegistro = true;
    }

    // Método p/ carregar inputs do form.
    public function edit($id)
    {
        $registro = Evento::find($id);
        $this->form->setRegistro($registro);
        $this->registroEditMode = true;
        $this->modalRegistro = true;
    }

    // Método p/ salvar: STORE ou UPDATE
    public function save()
    {
        if ($this->registroEditMode) {
            $this->form->update();
            $this->registroEditMode = false;
            $this->success('Registro salvo com sucesso!');
        } else {
            $this->form->store();
            $this->success('Registro incluído com sucesso!');
        }
        $this->modalRegistro = false;
    }

    // Método p/ confirmar delete.
    public function confirmDelete($id)
    {
        $this->registro_id = $id;
        $this->modalConfirmDelete = true;
    }

    // Método para deletar.
    public function delete($id)
    {
        Evento::find($id)->delete();
        $this->modalConfirmDelete = false;
        $this->success('Registro excluído com sucesso!');
    }

    public function filtrar()
    {
        $this->qdeFilter = 0;
        if ($this->fil_grupo) {
            $this->qdeFilter++;
        }
        if ($this->fil_local) {
            $this->qdeFilter++;
        }
        if ($this->date_init) {
            $this->qdeFilter++;
        }
        if ($this->search) {
            $this->qdeFilter++;
        }

        $this->eventos();
        $this->showDrawer = false;
    }

    public function limpaFiltros()
    {
        $this->search = '';
        $this->fil_grupo = '';
        $this->fil_local = '';
        //$this->fil_tipo = '';
        $this->date_init = '';
        $this->date_end = '';
        $this->showDrawer = false;
        $this->qdeFilter = 0;
    }
}
