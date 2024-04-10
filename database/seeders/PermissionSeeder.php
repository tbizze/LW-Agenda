<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // FUNÇÕES DA APLICAÇÃO
        // ----------------------------------------------------------------
        $role1 = Role::create([
            'name' => 'Admin',
            'description' => 'Usuário super administrador. Acesso total, inclusive administra usuários e permissões.'
        ]);
        $role2 = Role::create([
            'name' => 'Geral',
            'description' => 'Usuário com amplos poderes no sistema, com exceção na administração de usuários e permissões.'
        ]); 
        $role3 = Role::create([
            'name' => 'Basico',
            'description' => 'Usuário com poucas permissões, apenas consultar.'
        ]); 

        // PERMISSÕES DA APLICAÇÃO
        // ----------------------------------------------------------------

        // Administrar funções da aplicação.
        Permission::create([
            'name'          => 'admin.roles.index',
            'description'   => 'Ver funções',
            'model'         => 'SEG: Funções',
        ])->syncRoles([$role1]);
        Permission::create([
            'name'          => 'admin.roles.create',
            'description'   => 'Criar funções',
            'model'         => 'SEG: Funções',
        ])->syncRoles([$role1]);
        Permission::create([
            'name'          => 'admin.roles.edit',
            'description'   => 'Editar funções',
            'model'         => 'SEG: Funções',
        ])->syncRoles([$role1]);
        Permission::create([
            'name'          => 'admin.roles.delete',
            'description'   => 'Deletar funções',
            'model'         => 'SEG: Funções',
        ])->syncRoles([$role1]);

        // Administrar permissões da aplicação.
        Permission::create([
            'name'          => 'admin.permissions.index',
            'description'   => 'Ver permissões',
            'model'         => 'SEG: Permissões',
        ])->syncRoles([$role1]);
        Permission::create([
            'name'          => 'admin.permissions.create',
            'description'   => 'Criar permissões',
            'model'         => 'SEG: Permissões',
        ])->syncRoles([$role1]);
        Permission::create([
            'name'          => 'admin.permissions.edit',
            'description'   => 'Editar permissões',
            'model'         => 'SEG: Permissões',
        ])->syncRoles([$role1]);
        Permission::create([
            'name'          => 'admin.permissions.delete',
            'description'   => 'Deletar permissões',
            'model'         => 'SEG: Permissões',
        ])->syncRoles([$role1]);

        // Atribuir funções a usuários.
        Permission::create([
            'name'          => 'admin.user-has-roles.index',
            'description'   => 'Ver funções de usuários',
            'model'         => 'SEG: Usuário',
        ])->syncRoles([$role1]);
        Permission::create([
            'name'          => 'admin.user-has-roles.edit',
            'description'   => 'Editar funções de usuários',
            'model'         => 'SEG: Usuário',
        ])->syncRoles([$role1]);
        Permission::create([
            'name'          => 'admin.user-has-roles.ban',
            'description'   => 'Bloquear/desbloquear usuários',
            'model'         => 'SEG: Usuário',
        ])->syncRoles([$role1]);
    }
}
