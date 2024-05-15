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
        /**
         * FUNÇÕES DA APLICAÇÃO
         * Cria algumas funções exigidas para a aplicação:
         */
        $role_admin = Role::create([
            'name' => 'Admin',
            'description' => 'Usuário super administrador. Acesso total, inclusive administra usuários e permissões.'
        ]);
        $role_geral = Role::create([
            'name' => 'Geral',
            'description' => 'Usuário com amplos poderes no sistema, com exceção na administração de usuários e permissões.'
        ]);
        $role_basico = Role::create([
            'name' => 'Básico',
            'description' => 'Usuário com poucas permissões, apenas consultar.'
        ]);

        /**
         * PERMISSÕES DA APLICAÇÃO
         * Cria algumas permissões exigidas para a aplicação:
         */

        // Administrar funções da aplicação.
        Permission::create([
            'name'          => 'admin.roles.index',
            'description'   => 'Ver funções',
            'model'         => 'SEG: Funções',
        ])->syncRoles([$role_admin]);
        Permission::create([
            'name'          => 'admin.roles.create',
            'description'   => 'Criar funções',
            'model'         => 'SEG: Funções',
        ])->syncRoles([$role_admin]);
        Permission::create([
            'name'          => 'admin.roles.edit',
            'description'   => 'Editar funções',
            'model'         => 'SEG: Funções',
        ])->syncRoles([$role_admin]);
        Permission::create([
            'name'          => 'admin.roles.delete',
            'description'   => 'Deletar funções',
            'model'         => 'SEG: Funções',
        ])->syncRoles([$role_admin]);

        // Administrar permissões da aplicação.
        Permission::create([
            'name'          => 'admin.permissions.index',
            'description'   => 'Ver permissões',
            'model'         => 'SEG: Permissões',
        ])->syncRoles([$role_admin]);
        Permission::create([
            'name'          => 'admin.permissions.create',
            'description'   => 'Criar permissões',
            'model'         => 'SEG: Permissões',
        ])->syncRoles([$role_admin]);
        Permission::create([
            'name'          => 'admin.permissions.edit',
            'description'   => 'Editar permissões',
            'model'         => 'SEG: Permissões',
        ])->syncRoles([$role_admin]);
        Permission::create([
            'name'          => 'admin.permissions.delete',
            'description'   => 'Deletar permissões',
            'model'         => 'SEG: Permissões',
        ])->syncRoles([$role_admin]);

        // Atribuir funções a usuários.
        Permission::create([
            'name'          => 'admin.user-has-roles.index',
            'description'   => 'Ver funções de usuários',
            'model'         => 'SEG: Usuário',
        ])->syncRoles([$role_admin]);
        Permission::create([
            'name'          => 'admin.user-has-roles.edit',
            'description'   => 'Editar funções de usuários',
            'model'         => 'SEG: Usuário',
        ])->syncRoles([$role_admin]);
        Permission::create([
            'name'          => 'admin.user-has-roles.ban',
            'description'   => 'Bloquear/desbloquear usuários',
            'model'         => 'SEG: Usuário',
        ])->syncRoles([$role_admin]);

        /**
         * MÓDULO EVENTOS
         * Cria permissões para o módulo:
         */

        // Permissões com EventoArea.
        // Atribuído à função 'Geral' => $role_geral.
        Permission::create([
            'name'          => 'evento.areas.index',
            'description'   => 'Listar áreas de evento',
            'model'         => 'Evento area',
        ])->syncRoles([$role_geral]);
        Permission::create([
            'name'          => 'evento.areas.create',
            'description'   => 'Criar áreas de evento',
            'model'         => 'Evento area',
        ])->syncRoles([$role_geral]);
        Permission::create([
            'name'          => 'evento.areas.edit',
            'description'   => 'Editar áreas de evento',
            'model'         => 'Evento area',
        ])->syncRoles([$role_geral]);
        Permission::create([
            'name'          => 'evento.areas.delete',
            'description'   => 'Deletar áreas de evento',
            'model'         => 'Evento area',
        ])->syncRoles([$role_geral]);

        // Permissões com EventoGrupo.
        // Atribuído à função 'Geral' => $role_geral.
        Permission::create([
            'name'          => 'evento.grupos.index',
            'description'   => 'Listar grupos de evento',
            'model'         => 'Evento grupo',
        ])->syncRoles([$role_geral]);
        Permission::create([
            'name'          => 'evento.grupos.create',
            'description'   => 'Criar grupos de evento',
            'model'         => 'Evento grupo',
        ])->syncRoles([$role_geral]);
        Permission::create([
            'name'          => 'evento.grupos.edit',
            'description'   => 'Editar grupos de evento',
            'model'         => 'Evento grupo',
        ])->syncRoles([$role_geral]);
        Permission::create([
            'name'          => 'evento.grupos.delete',
            'description'   => 'Deletar grupos de evento',
            'model'         => 'Evento grupo',
        ])->syncRoles([$role_geral]);

        // Permissões com EventoLocal.
        // Atribuído à função 'Geral' => $role_geral.
        Permission::create([
            'name'          => 'evento.locals.index',
            'description'   => 'Listar locais de evento',
            'model'         => 'Evento local',
        ])->syncRoles([$role_geral]);
        Permission::create([
            'name'          => 'evento.locals.create',
            'description'   => 'Criar locais de evento',
            'model'         => 'Evento local',
        ])->syncRoles([$role_geral]);
        Permission::create([
            'name'          => 'evento.locals.edit',
            'description'   => 'Editar locais de evento',
            'model'         => 'Evento local',
        ])->syncRoles([$role_geral]);
        Permission::create([
            'name'          => 'evento.locals.delete',
            'description'   => 'Deletar locais de evento',
            'model'         => 'Evento local',
        ])->syncRoles([$role_geral]);

        // Permissões com Evento.
        // Atribuído à função 'Geral' => $role_geral.
        Permission::create([
            'name'          => 'eventos.index',
            'description'   => 'Listar eventos',
            'model'         => 'Evento local',
        ])->syncRoles([$role_geral]);
        Permission::create([
            'name'          => 'eventos.create',
            'description'   => 'Criar eventos',
            'model'         => 'Evento local',
        ])->syncRoles([$role_geral]);
        Permission::create([
            'name'          => 'eventos.edit',
            'description'   => 'Editar eventos',
            'model'         => 'Evento local',
        ])->syncRoles([$role_geral]);
        Permission::create([
            'name'          => 'eventos.delete',
            'description'   => 'Deletar eventos',
            'model'         => 'Evento local',
        ])->syncRoles([$role_geral]);
    }
}
