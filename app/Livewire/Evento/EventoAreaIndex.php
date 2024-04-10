<?php

namespace App\Livewire\Evento;

use App\Livewire\Forms\Evento\EventoAreaForm;
use App\Models\EventoArea;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class EventoAreaIndex extends Component
{
    use Toast;
    use WithPagination;

    public array $sortBy = ['column' => 'nome', 'direction' => 'asc'];
    public string $search = '';

    public bool $modalRegistro = false;
    public bool $modalConfirmDelete = false;
    public bool $registroEditMode = false;

    public EventoAreaForm $form;
    public $registro_id = '';
    public $page_title = 'Evento Areas';

    /* Renderiza componente */
    #[Title('Evento Areas')]
    public function render()
    {
        return view('livewire.evento.evento-area-index',[
            'headers' => $this->headers(),
            'evento_areas' => $this->evento_areas(),
        ]);
    }

    // Método p/ obter dados da tabela
    public function evento_areas()
    {
        return EventoArea::query()
            ->when($this->search, function ($query, $val) {
                $query->where('nome', 'like', '%' . $val . '%');
                $query->orWhere('notas', 'like', '%' . $val . '%');
                return $query;
            })
            ->orderBy(...array_values($this->sortBy))
            ->paginate(10);
    }

    //* Método p/ Cabeçalho da tabela
    public function headers()
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'bg-base-200 w-1'],
            ['key' => 'nome', 'label' => 'Nome'],
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
        $registro = EventoArea::find($id);
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
        EventoArea::find($id)->delete();
        $this->modalConfirmDelete = false;
        $this->success('Registro excluído com sucesso!');
    }
}
