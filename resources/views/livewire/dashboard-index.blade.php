<div>
    {{-- Cabeçalho da página --}}
    <x-mary-header title="Dashboard" subtitle="Painel de resumo.">
    </x-mary-header>
    
    <div class=" flex gap-5">
        <x-mary-card title="Próximos eventos" shadow class="w-1/3">
            @foreach ($nextEvets as $item)
                <x-mary-list-item :item="$item" no-hover>
                    <x-slot:value>
                        {{ $item->nome }}
                    </x-slot:value>
                    <x-slot:sub-value>
                        {{ $item->start_date->format('d/m/Y') }} | {{ isset($item->start_time) ? $item->start_time->format('H:i') : '' }}
                    </x-slot:sub-value>
                    <x-slot:actions>
                        {{ $item->to_grupo_nome }}
                    </x-slot:actions>
                </x-mary-list-item>
            @endforeach
            {{-- <x-slot:actions>
                <x-mary-button label="Ver todos" class=" btn-secondary btn-sm" link="{{ route('movimentos.index') }}" spinner="save" />
            </x-slot:actions> --}}
        </x-mary-card>

        <x-mary-card title="Últimos eventos" shadow class="w-1/3">
            @foreach ($previousEvets as $item)
                <x-mary-list-item :item="$item" no-hover>
                    <x-slot:value>
                        {{ $item->historico }}
                    </x-slot:value>
                    <x-slot:sub-value>
                        {{ $item->start_date->format('d/m/Y') }} | {{ isset($item->start_time) ? $item->start_time->format('H:i') : '' }}
                    </x-slot:sub-value>
                    <x-slot:actions>
                        {{ $item->to_grupo_nome }}
                    </x-slot:actions>
                </x-mary-list-item>
            @endforeach
            {{-- <x-slot:actions>
                <x-mary-button label="Ver todos" class=" btn-secondary btn-sm" link="{{ route('movimentos.index') }}" spinner="save" />
            </x-slot:actions> --}}
        </x-mary-card>

        {{-- <x-mary-card title="Últimos movimentos" shadow class="w-1/3">
            @foreach ($movtos_d as $movimento)
                <x-mary-list-item :item="$movimento" value="valor" sub-value="historico" />
            @endforeach
        </x-mary-card> --}}
    </div>
</div>
