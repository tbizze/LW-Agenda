<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\Admin\RoleForm;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;
use Spatie\Permission\Models\Role;

class RoleIndex extends Component
{
    use Toast;
    use WithPagination;

    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];
    public string $search = '';

    public bool $modalRegistro = false;
    public bool $modalConfirmDelete = false;
    public bool $registroEditMode = false;

    public RoleForm $form;
    public $registro_id = '';
    public $page_title = 'Funções';

    /* Renderiza componente */
    #[Title('Funções')]
    public function render()
    {
        return view('livewire.admin.role-index',[
            'headers' => $this->headers(),
            'roles' => $this->roles(),
        ]);
    }

    // Método p/ obter dados da tabela
    public function roles()
    {
        return Role::query()
            ->when($this->search, function ($query, $val) {
                $query->where('name', 'like', '%' . $val . '%');
                $query->orWhere('description', 'like', '%' . $val . '%');
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
            ['key' => 'name', 'label' => 'Nome'],
            ['key' => 'description', 'label' => 'Descrição', 'sortable' => false],
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
        $registro = Role::find($id);
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
        Role::find($id)->delete();
        $this->modalConfirmDelete = false;
        $this->success('Registro excluído com sucesso!');
    }
}
