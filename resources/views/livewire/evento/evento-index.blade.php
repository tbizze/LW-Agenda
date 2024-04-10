<div>
    {{-- Cabeçalho da página --}}
    <x-mary-header :title="$page_title" subtitle="Últimos registros">
        <x-slot:middle class="!justify-end">
            <x-mary-input icon="o-magnifying-glass" placeholder="Search..." wire:model.live="search" />
        </x-slot:middle>
        <x-slot:actions>
            <x-mary-button icon="o-funnel" wire:click="showDrawer = true" class="relative">
                @if ($qdeFilter > 0)
                    <x-mary-badge :value="$qdeFilter" class="badge-error absolute -right-2 -top-2" />
                @endif
            </x-mary-button>
            @can('eventos.create')
                <x-mary-button icon="o-plus" class="btn-primary" @click="$wire.showModalRegistro()" />
            @endcan

        </x-slot:actions>
    </x-mary-header>

    {{-- Renderiza tabela --}}
    <x-mary-card shadow class=" bg-white">
        <x-mary-table :headers="$headers" :rows="$eventos" striped @row-click="$wire.edit($event.detail.id)"
            with-pagination :sort-by="$sortBy" class="table table-xs">
            {{-- Personaliza / formata células  --}}
            @scope('cell_start_date', $evento)
                {{ $evento->start_date->format('d/m/Y') }}
            @endscope
            @scope('cell_start_time', $evento)
                {{ $evento->start_time->format('H:i:s') }}
            @endscope
            {{-- Monta coluna de ações  --}}
            @scope('actions', $evento)
                <div class="flex gap-1">
                    @can('eventos.edit')
                        <x-mary-button icon="o-document-duplicate" wire:click="copyRecord({{ $evento->id }})" spinner
                            class="btn-sm btn-outline border-none p-1" />
                    @endcan
                    @can('eventos.delete')
                        <x-mary-button icon="o-trash" wire:click="confirmDelete({{ $evento->id }})" spinner
                            class="btn-sm btn-outline border-none text-error p-1" />
                    @endcan
                </div>
            @endscope
        </x-mary-table>
    </x-mary-card>

    {{-- MODAL: Criar/Editar --}}
    <x-mary-modal wire:model="modalRegistro" title="Criar/Editar registro" class="backdrop-blur">
        <x-mary-form wire:submit="save">
            <x-mary-input label="Nome" wire:model="form.nome" />
            <div class="flex justify-between gap-2">
                <div class="w-1/2">
                    <x-mary-datepicker label="Data início" wire:model="form.start_date" :config="$date_config" />
                </div>
                <div class="w-1/2">
                    <x-mary-datetime label="Hora início" wire:model="form.start_time" type="time" />
                </div>
            </div>
            <div class="flex justify-between gap-2">
                <div class="w-1/2">
                    <x-mary-datetime label="Data fim" wire:model="form.end_date" />
                </div>
                <div class="w-1/2">
                    <x-mary-datetime label="Hora fim" wire:model="form.end_time" type="time" />
                </div>
            </div>
            <div class="flex justify-between gap-2">
                <div class="w-1/2">
                    <x-mary-select label="Grupo" :options="$evento_grupos" wire:model="form.evento_grupo_id"
                        placeholder="Selecione..." />
                </div>
                <div class="w-1/2">
                    <x-mary-select label="Local" :options="$evento_locals" wire:model="form.evento_local_id"
                        placeholder="Selecione..." />
                </div>
            </div>
            <x-mary-textarea label="Notas" wire:model="form.notas" hint="Max. 100 caracteres" rows="2" />
            <x-slot:actions>
                <x-mary-button label="Cancel" @click="$wire.modalRegistro = false" />
                @can('eventos.edit')
                    <x-mary-button label="Salvar" class="btn-primary" type="submit" spinner="save" />
                @endcan
            </x-slot:actions>
        </x-mary-form>
    </x-mary-modal>

    {{-- Drawer Right -> FILTRAR --}}
    <x-mary-drawer title="Filtros" wire:model="showDrawer" with-close-button right class=" w-1/3 lg:w-2/6">
        <x-mary-form wire:submit="filtrar">
            <x-mary-input label="Hist./Notas" placeholder="Digite uma pesquisa..."
                wire:model="search" />
            <x-mary-select label="Grupo" :options="$evento_grupos" wire:model="fil_grupo"
                placeholder="Selecione..." />
            <x-mary-select label="Local" :options="$evento_locals" wire:model="fil_local" placeholder="Selecione..." />
            {{-- <x-mary-select label="Tipo" :options="$pgto_tipo" wire:model="fil_tipo" placeholder="Selecione um tipo" /> --}}
            <div class="flex justify-between gap-2">
                <div class="w-1/2">
                    <x-mary-datepicker label="Data início" wire:model="date_init" icon-right="o-calendar"
                        :config="$date_config" />
                </div>
                <div class="w-1/2">
                    <x-mary-datepicker label="Data fim" wire:model="date_end" icon-right="o-calendar"
                        :config="$date_config" />
                </div>
            </div>
            <x-slot:actions>
                <x-mary-button label="Limpar" @click="$wire.limpaFiltros()" />
                <x-mary-button label="Filtrar" type="submit" icon="o-check" class="btn-primary" />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-drawer>
</div>