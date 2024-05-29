<div>
    {{-- Cabeçalho da página --}}
    <x-mary-header :title="$page_title" subtitle="Últimos registros">
        <x-slot:middle class="!justify-end">
            <x-mary-input icon="o-magnifying-glass" placeholder="Search..." wire:model.live="search" />
        </x-slot:middle>
        <x-slot:actions>
            @can('recibos.create')
                <x-mary-button icon="o-plus" class="btn-primary" @click="$wire.showModalRegistro()" />
            @endcan

        </x-slot:actions>
    </x-mary-header>

    {{-- Renderiza tabela --}}
    <x-mary-card shadow class=" bg-white">
        {{-- <x-mary-table :headers="$headers" :rows="$recibos" striped @row-click="$wire.edit($event.detail.id)" --}}
        <x-mary-table :headers="$headers" :rows="$recibos" striped @row-click="$wire.showModalRegistro($event.detail.id)"
            with-pagination :sort-by="$sortBy">
            {{-- Personaliza / formata células  --}}
            @scope('cell_data', $recibo)
                {{ isset($recibo->data) ? $recibo->data->format('d/m/Y') : '' }}
            @endscope
            @scope('actions', $recibo)
                <div class="flex gap-1">
                    @can('recibos.edit')
                        <x-mary-button icon="o-document-duplicate" wire:click="copyRecord({{ $recibo->id }})" spinner
                            class="btn-sm btn-outline border-none p-1" />
                    @endcan
                    @can('recibos.delete')
                        <x-mary-button icon="o-trash" wire:click="confirmDelete({{ $recibo->id }})" spinner
                            class="btn-sm btn-outline border-none text-error p-1" />
                    @endcan
                </div>
            @endscope
        </x-mary-table>
    </x-mary-card>

    {{-- MODAL: Criar/Editar --}}
    <x-mary-modal wire:model="modalRegistro" title="Criar/Editar registro" class="backdrop-blur">
        <x-mary-form wire:submit="submitForm">
            <div class="flex justify-between gap-2">
                <div class="w-1/2">
                    <x-mary-input label="Valor" wire:model="valor" money locale="pt-BR" />
                </div>
                <div class="w-1/2">
                    <x-mary-datepicker label="Data" wire:model="data" :config="$date_config" />
                </div>
            </div>

            <x-mary-input label="Histórico" wire:model="historico" />

            <div class="flex justify-between gap-2">
                <div class="w-1/2">
                    <x-mary-input label="Recebedor" wire:model="recebedor" />
                </div>
                <div class="w-1/2">
                    <x-mary-input label="CPF/CNPJ" wire:model="cpf_cnpj_receb"
                        x-mask:dynamic="$input.length > 14 ? '99.999.999/9999-99' : '999.999.999-99'" />
                </div>
            </div>

            <div class="flex justify-between gap-2">
                <div class="w-1/2">
                    <x-mary-input label="Pagador" wire:model="pagador" />
                </div>
                <div class="w-1/2">
                    <x-mary-input label="CPF/CNPJ" wire:model="cpf_cnpj_pagad"
                        x-mask:dynamic="$input.length > 14 ? '99.999.999/9999-99' : '999.999.999-99'" />
                </div>
            </div>

            <x-mary-input label="Local" wire:model="local" />

            {{-- //'valor','historico','data','local','pagador','cpf_cnpj_pagad','recebedor','cpf_cnpj_receb', --}}
            <x-slot:actions>
                <x-mary-button label="Cancel" @click="$wire.modalRegistro = false" />
                @can('recibos.edit')
                    <x-mary-button label="Salvar" class="btn-primary" type="submit" spinner="save" />
                @endcan
            </x-slot:actions>
        </x-mary-form>
    </x-mary-modal>

    {{-- MODAL: Confirma delete --}}
    <x-mary-modal wire:model="modalConfirmDelete" title="Deletar registro" class="backdrop-blur">
        <div class="mb-5">Deseja realmente excluir o <span class=" font-bold">registro nº
                [{{ $registro_id }}]</span>?</div>
        <x-slot:actions>
            <x-mary-button label="Cancel" @click="$wire.modalConfirmDelete = false" />
            <x-mary-button label="Excluir" wire:click="delete({{ $registro_id }})" class="btn-error" spinner="save" />
        </x-slot:actions>
    </x-mary-modal>

    @push('styles')
        {{-- Flatpickr  --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    @endpush
    @push('scripts')
        {{-- Flatpickr  --}}
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://npmcdn.com/flatpickr/dist/l10n/pt.js"></script>
        {{--  Currency  --}}
        <script src="https://cdn.jsdelivr.net/gh/robsontenorio/mary@0.44.2/libs/currency/currency.js"></script>
        <script>
            flatpickr.localize(flatpickr.l10ns.pt);
        </script>
    @endpush
</div>
