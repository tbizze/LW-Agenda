<?php

namespace App\Livewire\Forms\Admin;

use Livewire\Attributes\Validate;
use Livewire\Form;
use Spatie\Permission\Models\Permission;

class PermissionForm extends Form
{
    public ?Permission $permission;

    // Regras de validação.
    #[Validate([
        'name' => ['required', 'string', 'min:3', 'max:50'],
        'model' => ['nullable', 'string', 'max:70'],
        'description' => ['nullable', 'string', 'max:100'],
        'permission_to_roles' => ['array'],
    ])]

    // Campos da tabela.
    public $name;
    public $model;
    public $description;
    public $permission_to_roles = [];

    // Método p/ popular classe a partir do BD.
    public function setRegistro(Permission $registro)
    {
        // Obtém as funções relacionadas com a permissão atual.
        $permission_roles = $registro->roles->pluck('id');

        $this->permission = $registro;
        $this->name = $registro->name;
        $this->model = $registro->model;
        $this->description = $registro->description;
        $this->permission_to_roles = $permission_roles;
    }

    // Método p/ persistir no BD.
    public function store()
    {
        
        // Cria um model com os dados aprovados nas validações...
        // Persiste o model atualizado no DB.
        $this->validate();
        
        $permission = Permission::create([
            'name' => $this->name,
            'model' => $this->model,
            'description' => $this->description,
            'guard_name' => 'web',
        ]);

        // Atribui as funções passadas, à permissão criada.
        if ($this->permission_to_roles) {
            
            // Método p/ converter dados submetidos no form para inteiro. 
            // Está chegando array de strings.
            $role_selected = collect($this->permission_to_roles)->map(function (int $item, int $key) {
                return (int)$item;
            });
            
            // Persiste no BD. Sincroniza funções na permissão presente.
            $permission->syncRoles($role_selected);
        }

        // Limpa formulário.
        $this->reset();
    }

    // Método p/ atualizar no BD.
    public function update()
    {
        // Valida informações submetidas.
        $this->validate();
        // Persiste o model atualizado no DB.
        $this->permission->update([
            'name' => $this->name,
            'model' => $this->model,
            'description' => $this->description,
        ]);

        // Atribui as funções passadas, à permissão criada.
        if ($this->permission_to_roles) {
            
            // Método p/ converter dados submetidos no form para inteiro. 
            // Está chegando array de strings.
            $role_selected = collect($this->permission_to_roles)->map(function (int $item, int $key) {
                return (int)$item;
            });
            
            // Persiste no BD. Sincroniza funções na permissão presente.
            $this->permission->syncRoles($role_selected);
        }
        $this->reset();
    }
}
