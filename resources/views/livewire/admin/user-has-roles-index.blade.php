<div>
    {{-- Cabeçalho da página --}}
    <x-mary-header :title="$page_title" subtitle="Últimos registros">
        <x-slot:middle class="!justify-end">
            <x-mary-input icon="o-magnifying-glass" placeholder="Search..." wire:model.live="search" />
        </x-slot:middle>
        <x-slot:actions>
            @can('admin.user-has-roles.create')
                <x-mary-button icon="o-plus" class="btn-primary" @click="$wire.showModalRegistro()" />
            @endcan

        </x-slot:actions>
    </x-mary-header>

    {{-- Renderiza tabela --}}
    <x-mary-card shadow class=" bg-white">
        <x-mary-table :headers="$headers" :rows="$users" striped @row-click="$wire.edit($event.detail.id)"
            with-pagination :sort-by="$sortBy">
            @scope('cell_roles_name', $user)
                <div class=" flex gap-1">
                    @foreach ($user->roles as $role)
                        <x-mary-badge :value="$role->name" class="badge-outline " />
                    @endforeach
                </div>
            @endscope
            @scope('actions', $user)
                @can('admin.user-has-roles.delete')
                    <x-mary-button icon="o-trash" wire:click="confirmDelete({{ $user->id }})" spinner
                        class="btn-sm btn-outline border-none text-error p-1" />
                @endcan
            @endscope
        </x-mary-table>
    </x-mary-card>

    {{-- MODAL: Criar/Editar --}}
    <x-mary-modal wire:model="modalRegistro" title="Criar/Editar registro" class="backdrop-blur">
        <x-mary-form wire:submit="save">
            <x-mary-input label="Nome" wire:model="form.name" disabled />
            <x-mary-input label="Email" wire:model="form.email" disabled />

            <div class="  font-semibold">Funções</div>
            <div class="flex flex-wrap gap-2">
                @foreach ($roles as $role)
                    <x-mary-checkbox :id="'role_' . $role->id" :label="$role->name" wire:model="form.user_has_roles"
                        :value="$role->id" />
                @endforeach
            </div>

            <x-slot:actions>
                <x-mary-button label="Cancel" @click="$wire.modalRegistro = false" />
                @can('admin.user-has-roles.edit')
                    <x-mary-button label="Salvar" class="btn-primary" type="submit" spinner="save" />
                @endcan
            </x-slot:actions>
        </x-mary-form>
    </x-mary-modal>
</div>
