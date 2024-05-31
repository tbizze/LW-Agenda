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
            @scope('cell_dt_venc', $registro)
                {{ isset($registro->dt_venc) ? $registro->dt_venc->format('d/m/Y') : '' }}
            @endscope
            @scope('cell_dt_pgto', $registro)
                {{ isset($registro->dt_pgto) ? $registro->dt_pgto->format('d/m/Y') : '' }}
            @endscope
            @scope('cell_to_fatura_status_nome', $registro)
                @if ($registro->fatura_status_id == 2)
                    <x-mary-badge value="{{ $registro->to_fatura_status_nome }}" class="badge-error" />
                @elseif ($registro->fatura_status_id == 3)
                    <x-mary-badge value="{{ $registro->to_fatura_status_nome }}" class="badge-primary text-sm" />
                @else
                    <x-mary-badge value="{{ $registro->to_fatura_status_nome }}" class="badge-outline" />
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
</div>
