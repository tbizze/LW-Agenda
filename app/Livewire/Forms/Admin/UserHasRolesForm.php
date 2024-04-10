<?php

namespace App\Livewire\Forms\Admin;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserHasRolesForm extends Form
{
    public ?User $user;

    // Regras de validação.
    #[Validate([
        'user_has_roles' => ['array'],
    ])]

    // Campos da tabela.
    public $name;
    public $email;
    public $user_has_roles = [];

    // Método p/ popular classe a partir do BD.
    public function setRegistro(User $registro)
    {
        // Obtém as funções relacionadas com a permissão atual.
        // Método pluck('role_id') coloca a coluna definida num array.
        $roles = DB::table('model_has_roles')->where('model_id', $registro->id)->pluck('role_id');

        $this->user = $registro;
        $this->name = $registro->name;
        $this->email = $registro->email;
        $this->user_has_roles = $roles;
    }

    // Método p/ atualizar no BD.
    public function update()
    {
        // Atribui as funções passadas, à permissão criada.
        if ($this->user_has_roles) {
            $this->user->roles()->sync($this->user_has_roles);
        }
        $this->reset();
    }
}
