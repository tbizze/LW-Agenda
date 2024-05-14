<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Title;
use Livewire\Component;
use Mary\Traits\Toast;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleHasPermissionsEdit extends Component
{
    use Toast;

    //public RoleForm $form;
    public $registro_id = '';
    public $page_title = '';
    public $page_subtitle = '';
    public $role_has_permissions = [];

    /* Renderiza componente */
    #[Title('Funções')]
    public function render()
    {
        return view('livewire.admin.role-has-permissions-edit', [
            'permissions' => Permission::query()
                ->selectRaw('id,name,description,model')
                ->get()
                ->groupBy('model')
        ]);
    }

    public function mount(Role $role)
    {
        $this->registro_id = $role->id;
        $this->page_title = $role->name;
        $this->page_subtitle = $role->description;

        // Obtém as permissões relacionadas com a função atual.
        $this->role_has_permissions = $role->permissions->pluck('id');
    }

    // Método p/ Cancelar.
    public function cancel()
    {
        $this->redirectRoute('admin.roles.index');
    }

    // Método p/ salvar: STORE ou UPDATE
    public function save()
    {
        // Atribui as funções passadas, à permissão criada.
        if ($this->role_has_permissions) {
            // Carrega modelo da Função presente.
            $role = Role::find($this->registro_id);
            // Método p/ converter dados submetidos no form para inteiro.
            // Está chegando array de strings.
            $permission_selected = collect($this->role_has_permissions)->map(function (int $item, int $key) {
                return (int)$item;
            });

            // Persiste no BD. Sincroniza permissões na função presente.
            $role->syncPermissions($permission_selected);

            //$this->redirectRoute('admin.roles');
            $this->success('Registro salvo com sucesso!', redirectTo: '/admin/roles');

        }
    }
}
