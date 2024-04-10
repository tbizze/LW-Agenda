<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\Admin\UserHasRolesForm;
use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;
use Spatie\Permission\Models\Role;

class UserHasRolesIndex extends Component
{
    use Toast;
    use WithPagination;

    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];
    public string $search = '';

    public bool $modalRegistro = false;
    public bool $modalConfirmDelete = false;
    public bool $registroEditMode = false;

    public UserHasRolesForm $form;
    public $registro_id = '';
    public $page_title = 'Funções por usuário';

    /* Renderiza componente */
    #[Title('Funções por usuário')]
    public function render()
    {
        return view('livewire.admin.user-has-roles-index',[
            'headers' => $this->headers(),
            'users' => $this->users(),
            'roles' => Role::all(),
        ]);
    }

    // Método p/ obter dados da tabela
    public function users()
    {
        return User::query()
            ->withAggregate('roles', 'name')
            ->when($this->search, function ($query, $val) {
                $query->where('name', 'like', '%' . $val . '%');
                //$query->orWhere('description', 'like', '%' . $val . '%');
                //$query->orWhere('model', 'like', '%' . $val . '%');
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
            ['key' => 'email', 'label' => 'Email', 'sortable' => false],
            //['key' => 'model', 'label' => 'Modelo'],
            ['key' => 'roles_name', 'label' => 'Funções', 'sortBy' => 'roles_name'],

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
        $registro = User::find($id);
        $this->form->setRegistro($registro);
        $this->registroEditMode = true;
        $this->modalRegistro = true;
    }

    // Método p/ salvar: STORE ou UPDATE
    public function save()
    {
        //dd($this->registroEditMode);
        if ($this->registroEditMode) {
            //dd('update');
            $this->form->update();
            $this->registroEditMode = false;
            $this->success('Registro salvo com sucesso!');
        } else {
            //dd('store');
            /* $this->form->store();
            $this->success('Registro incluído com sucesso!'); */
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
        User::find($id)->delete();
        $this->modalConfirmDelete = false;
        $this->success('Registro excluído com sucesso!');
    }
}
