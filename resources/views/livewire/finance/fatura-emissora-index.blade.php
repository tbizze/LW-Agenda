<div>
    {{-- Cabeçalho da página --}}
    <x-mary-header :title="$page_title" subtitle="Últimos registros">
        <x-slot:middle class="!justify-end">
            <x-mary-input icon="o-magnifying-glass" placeholder="Search..." wire:model.live="search" />
        </x-slot:middle>
        <x-slot:actions>
            @can('recibos.create')
                <x-mary-button icon="o-plus" class="btn-primary" @click="$wire.openModal()" />
            @endcan

        </x-slot:actions>
    </x-mary-header>

    {{-- Renderiza tabela --}}
    <x-mary-card shadow class=" bg-white">
        <x-mary-table :headers="$headers" :rows="$registros" striped @row-click="$wire.openModal($event.detail.id)"
            with-pagination :sort-by="$sortBy">
            {{-- Personaliza / formata células  --}}
            @scope('cell_ativo', $registro)
                @if ($registro->ativo)
                    <x-mary-toggle checked class="toggle-sm" />
                @else
                    <x-mary-toggle class="toggle-sm" />
                @endif
            @endscope
            {{-- Monta coluna de ações  --}}
            @scope('actions', $registro)
                <div class="flex gap-1">
                    @can('recibos.edit')
                        <x-mary-button icon="o-document-duplicate" wire:click="copyRecord({{ $registro->id }})" spinner
                            class="btn-sm btn-outline border-none p-1" />
                    @endcan
                    @can('recibos.delete')
                        <x-mary-button icon="o-trash" wire:click="confirmDelete({{ $registro->id }})" spinner
                            class="btn-sm btn-outline border-none text-error p-1" />
                    @endcan
                </div>
            @endscope
        </x-mary-table>
    </x-mary-card>

    {{-- MODAL: Criar/Editar --}}
    <x-mary-modal wire:model="objectForm.modalRegistro" title="Criar/Editar registro" class="backdrop-blur">
        <x-mary-form wire:submit="submitForm">
            @if ($registroEdit)
                <div class="text-sm text-right italic text-gray-600">Editando registro: {{ $registroId }}</div>
            @endif

            <x-mary-input label="Nome" wire:model="objectForm.nome" />
            <x-mary-input label="Notas" wire:model="objectForm.notas" />
            {{-- <x-mary-input label="Ativo" wire:model="objectForm.ativo" /> --}}
            <x-mary-toggle label="Ativo" wire:model="objectForm.ativo" class="mt-2" />

            <x-slot:actions>
                <x-mary-button label="Cancel" @click="$wire.objectForm.modalRegistro = false" />
                @can('recibos.edit')
                    <x-mary-button label="Salvar" class="btn-primary" type="submit" spinner="save" />
                @endcan
            </x-slot:actions>
        </x-mary-form>
    </x-mary-modal>

    {{-- MODAL: Confirma delete --}}
    <x-mary-modal wire:model="objectForm.modalConfirmDelete" title="Deletar registro" class="backdrop-blur">
        <div class="mb-5">Deseja realmente excluir o <span class=" font-bold">registro nº
                [{{ $registroId }}]</span>?</div>
        <x-slot:actions>
            <x-mary-button label="Cancel" @click="$wire.objectForm.modalConfirmDelete = false" />
            <x-mary-button label="Excluir" wire:click="delete({{ $registroId }})" class="btn-error" spinner="save" />
        </x-slot:actions>
    </x-mary-modal>
</div>
