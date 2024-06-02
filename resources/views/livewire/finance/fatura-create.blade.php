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
        <x-mary-form wire:submit="submitForm">
            <div class="flex gap-3">
                <div class="w-1/3">
                    <x-mary-select label="Emissora" :options="$fatura_emissoras" wire:model="objectForm.fatura_emissora_id"
                        placeholder="Selecione..." />
                </div>
                <div class="w-1/3">
                    <x-mary-input label="Código" wire:model="objectForm.codigo" />
                </div>
                <div class="w-1/3">
                    <x-mary-input label="Data de vencimento" wire:model="objectForm.dt_venc" />
                </div>
                <div class="w-1/3">
                    <x-mary-input label="Valor" wire:model="objectForm.valor_fatura" />
                </div>
            </div>
            <div class="flex gap-3">
                <div class="w-1/4">
                    <x-mary-input label="Data de pgto." wire:model="objectForm.dt_pgto" />
                </div>
                <div class="w-1/4">
                    <x-mary-input label="Valor pgto." wire:model="objectForm.valor_pgto" />
                </div>
                <div class="w-1/4">
                    <x-mary-select label="Forma pgto." :options="$pgto_tipos" wire:model="objectForm.pgto_tipo_id"
                        placeholder="Selecione..." />
                </div>
                <div class="w-1/4">
                    <x-mary-select label="Status" :options="$fatura_statuses" wire:model="objectForm.fatura_status_id"
                        placeholder="Selecione..." />
                </div>
            </div>
            <x-mary-input label="Notas" wire:model="objectForm.notas" />

            <x-mary-hr />
            {{-- 'dt_compra', 'valor_compra', 'historico', 'parcelas', 'notas', 'fatura_id', 'fatura_grupo_id', --}}
            <div class="">Itens:</div>

            {{-- Linha item: DEFAULT --}}
            <div class="flex gap-3 bg-stone-50 border rounded">
                <div class="flex gap-3 p-2">
                    <div class="w-1/6">
                        <x-mary-input placeholder="Data compra" wire:model="objectForm.dt_compra.0" />
                    </div>
                    <div class="w-1/6">
                        <x-mary-input placeholder="Valor" wire:model="objectForm.valor_compra.0" />
                    </div>
                    <div class="w-2/6">
                        <x-mary-input placeholder="Histórico" wire:model="objectForm.historico.0" />
                    </div>
                    <div class="w-1/6">
                        <x-mary-input placeholder="Parcela" wire:model="objectForm.parcela.0" />
                    </div>
                    <div class="w-1/6">
                        <x-mary-select placeholder="Grupo" :options="$fatura_grupos" wire:model="objectForm.fatura_grupo_id.0"
                            placeholder="Selecione..." />
                    </div>
                </div>
                <div class="flex items-start py-2 pr-2">
                    <x-mary-button icon="o-trash" wire:click="removeItem()" spinner
                        class="w-12 border-none text-error p-1" />
                </div>
            </div>

            @foreach ($items as $key => $item)
                {{-- Linha item --}}
                <div class="flex gap-3 bg-stone-50 border rounded">
                    <div class="flex gap-3 p-2">
                        <div class="w-1/6">
                            <x-mary-input placeholder="Data compra"
                                wire:model="objectForm.dt_compra.{{ $item }}" />
                        </div>
                        <div class="w-1/6">
                            <x-mary-input placeholder="Valor"
                                wire:model="objectForm.valor_compra.{{ $item }}" />
                        </div>
                        <div class="w-2/6">
                            <x-mary-input placeholder="Histórico"
                                wire:model="objectForm.historico.{{ $item }}" />
                        </div>
                        <div class="w-1/6">
                            <x-mary-input placeholder="Parcela" wire:model="objectForm.parcela.{{ $item }}" />
                        </div>
                        <div class="w-1/6">
                            <x-mary-select placeholder="Grupo" :options="$fatura_grupos"
                                wire:model="objectForm.fatura_grupo_id.{{ $item }}"
                                placeholder="Selecione..." />
                        </div>
                        {{-- <div class="">{{ $key }} {{ $item }}</div> --}}
                    </div>
                    <div class="flex items-start py-2 pr-2">
                        <x-mary-button icon="o-trash" wire:click="removeItem({{ $key }})" spinner
                            class="w-12 border-none text-error p-1" />
                    </div>
                </div>
            @endforeach

            {{-- Adicionar --}}
            <x-mary-button icon="o-plus" class=" btn-primary" wire:click="addItem({{ $i }})">
                <span class=" uppercase">
                    Adicionar novo item
                </span>
            </x-mary-button>
            <x-slot:actions>
                <x-mary-button label="Cancelar" />
                <x-mary-button label="Salvar" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-card>
</div>
