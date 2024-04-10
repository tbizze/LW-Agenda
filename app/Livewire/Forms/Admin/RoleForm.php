<?php

namespace App\Livewire\Forms\Admin;

use Livewire\Attributes\Validate;
use Livewire\Form;
use Spatie\Permission\Models\Role;

class RoleForm extends Form
{
    public ?Role $role;

    // Regras de validação.
    #[Validate([
        'name' => ['required', 'string', 'min:3', 'max:50'],
        'description' => ['nullable', 'string', 'max:100'],
    ])]

    // Campos da tabela.
    public $name;
    public $description;

    // Método p/ popular classe a partir do BD.
    public function setRegistro(Role $registro)
    {
        $this->role = $registro;
        $this->name = $registro->name;
        $this->description = $registro->description;
    }

    // Método p/ persistir no BD.
    public function store()
    {
        $this->validate();
        Role::create([
            'name' => $this->name,
            'description' => $this->description,
            'guard_name' => 'web',
        ]);
        $this->reset();
    }

    // Método p/ atualizar no BD.
    public function update()
    {
        $this->validate();
        $this->role->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);
        $this->reset();
    }
}
