<div>
    {{-- Cabeçalho da página --}}
    <x-mary-header :title="$page_title" subtitle="Últimos registros">
        {{-- <x-slot:middle class="!justify-end">
            <x-mary-input icon="o-magnifying-glass" placeholder="Search..." wire:model.live="search" />
        </x-slot:middle>
        <x-slot:actions>
            @can('recibos.create')
                <x-mary-button icon="o-plus" class="btn-primary" @click="$wire.openModal()" />
            @endcan

        </x-slot:actions> --}}
    </x-mary-header>

    {{-- 'dt_venc', 'dt_pgto', 'valor_fatura', 'valor_pgto', 'codigo', 'notas', 'fatura_emissora_id', 'pgto_tipo_id', 'status_id' --}}
    {{-- Renderiza tabela --}}
    <x-mary-card shadow class=" bg-white max-w-6xl">
        <x-mary-form wire:submit="save">
            <div class="flex gap-3">
                <div class="w-1/3">
                    <x-mary-input label="Emissora" wire:model="objectForm.fatura_emissora_id" />
                </div>
                <div class="w-1/3">
                    <x-mary-input label="Data de vencimento" wire:model="objectForm.dt_venc" />
                </div>
                <div class="w-1/3">
                    <x-mary-input label="Código" wire:model="objectForm.codigo" />
                </div>
            </div>
            <div class="flex gap-3">
                <div class="w-1/3">
                    <x-mary-input label="Data de pgto." wire:model="objectForm.dt_venc" />
                </div>
                <div class="w-1/3">
                    <x-mary-input label="Valor pgto." wire:model="objectForm.codigo" />
                </div>
                <div class="w-1/3">
                    <x-mary-input label="Forma pgto." wire:model="objectForm.dt_venc" />
                </div>
            </div>
            <x-mary-input label="Notas" wire:model="objectForm.dt_venc" />
            <x-mary-input label="Amount" wire:model="objectForm.valor_fatura" prefix="USD" money
                hint="It submits an unmasked value" />

            <x-slot:actions>
                <x-mary-button label="Cancelar" />
                <x-mary-button label="Salvar" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-card>
</div>
