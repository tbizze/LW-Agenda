<div>
    {{-- Cabeçalho da página --}}
    <x-mary-header :title="$page_title" subtitle="Últimos registros">
        <x-slot:middle class="!justify-end">
            <x-mary-input icon="o-magnifying-glass" placeholder="Search..." wire:model.live="search" />
        </x-slot:middle>
        <x-slot:actions>
            <x-mary-button wire:click="monthPrevious()" class="relative">
                <x-mary-icon name="c-arrow-left" class="w-6 h-6" />
            </x-mary-button>
            <x-mary-button wire:click="monthNow()" class="relative"><span
                    class=" uppercase font-bold">Agora</span></x-mary-button>
            <x-mary-button wire:click="monthNext()" class="relative">
                <x-mary-icon name="c-arrow-right" class="w-6 h-6" />
            </x-mary-button>

            <x-mary-button icon="o-calendar-days" wire:click="openCalendar()" class="relative" />
            <x-mary-button id="openReportPdf" title="PDF" class="relative">
                <x-mary-icon name="o-document-arrow-down" class="w-6 h-6" />
            </x-mary-button>
            {{-- <x-mary-button id="pdf" title="PDF" class="relative" >PDF</x-mary-button>  --}}
            {{-- <x-mary-button id="pdf" title="PDF" :link="route('evento.pdf','mes='.$fil_mes.'&grupo='.$fil_grupo)" class="relative" >Abrir PDF</x-mary-button>  --}}
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
            with-pagination :sort-by="$sortBy">
            {{-- Personaliza / formata células  --}}
            @scope('cell_start_date', $evento)
                {{ isset($evento->start_date) ? $evento->start_date->format('d/m/Y') : '' }}
            @endscope
            @scope('cell_start_time', $evento)
                {{ isset($evento->start_time) ? $evento->start_time->format('H:i') : '' }}
            @endscope
            @scope('cell_all_day', $evento)
                @if ($evento->all_day)
                    <x-mary-checkbox checked disabled class="checkbox-sm" />
                @endif
            @endscope
            @scope('cell_areas_nome', $evento)
                <div class=" flex gap-1">
                    @foreach ($evento->areas as $area)
                        @if ($area->id == 1)
                            <x-mary-badge :value="$area->nome" class="badge-outline bg-purple-300" />
                        @endif
                        @if ($area->id == 2)
                            <x-mary-badge :value="$area->nome" class="badge-outline bg-green-300" />
                        @endif
                        @if ($area->id == 3)
                            <x-mary-badge :value="$area->nome" class="badge-outline bg-blue-300" />
                        @endif
                        @if ($area->id == 4)
                            <x-mary-badge :value="$area->nome" class="badge-outline bg-pink-300" />
                        @endif
                        @if ($area->id == 5)
                            <x-mary-badge :value="$area->nome" class="badge-outline bg-yellow-300" />
                        @endif
                        @if ($area->id == 6)
                            <x-mary-badge :value="$area->nome" class="badge-outline bg-orange-300" />
                        @endif
                        @if ($area->id == 7)
                            <x-mary-badge :value="$area->nome" class="badge-outline bg-red-300" />
                        @endif
                    @endforeach
                </div>
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
                <div class="w-2/5">
                    <x-mary-datepicker label="Data início" wire:model="form.start_date" :config="$date_config" />
                </div>
                <div class="w-2/5">
                    <x-mary-datetime label="Hora início" wire:model="form.start_time" type="time" />
                </div>
                <div class="w-1/5">
                    <label class="label label-text font-semibold pt-0 mb-3">Dia inteiro</label>
                    <x-mary-toggle wire:model="form.all_day" />
                </div>
            </div>
            <div class="flex justify-between gap-2">
                <div class="w-1/2">
                    <x-mary-datepicker label="Data fim" wire:model="form.end_date" :config="$date_config" />
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
            <div class="font-semibold">Áreas</div>
            <div class="flex flex-wrap gap-2">
                @foreach ($evento_areas as $area)
                    <x-mary-checkbox :id="'area_' . $area->id" :label="$area->name" wire:model="form.evento_areas_selected"
                        :value="$area->id" />
                @endforeach
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

    {{-- MODAL: Confirma delete --}}
    <x-mary-modal wire:model="modalConfirmDelete" title="Deletar registro" class="backdrop-blur">
        <div class="mb-5">Deseja realmente excluir o <span class=" font-bold">registro nº
                [{{ $registro_id }}]</span>?</div>
        <x-slot:actions>
            <x-mary-button label="Cancel" @click="$wire.modalConfirmDelete = false" />
            <x-mary-button label="Excluir" wire:click="delete({{ $registro_id }})" class="btn-error"
                spinner="save" />
        </x-slot:actions>
    </x-mary-modal>

    {{-- Drawer Right -> FILTRAR --}}
    <x-mary-drawer title="Filtros" wire:model="showDrawer" with-close-button right class=" w-1/3 lg:w-2/6">
        <x-mary-form wire:submit="filtrar">
            <x-mary-input label="Hist./Notas" placeholder="Digite uma pesquisa..." wire:model="search" />
            <x-mary-select label="Grupo" :options="$evento_grupos" wire:model="fil_grupo" placeholder="Selecione..." />
            <x-mary-select label="Local" :options="$evento_locals" wire:model="fil_local" placeholder="Selecione..." />
            <x-mary-select label="Mês" :options="$meses" wire:model="fil_mes" placeholder="Selecione..." />
            {{-- public array $users_multi_ids = []; --}}
            {{-- <x-mary-choices label="Areas" wire:model="fil_area_ids" :options="$evento_areas" allow-all /> --}}
            {{-- <div class="flex justify-between gap-2">
                <div class="w-1/2">
                    <x-mary-datepicker label="Data início" wire:model="date_init" icon-right="o-calendar"
                        :config="$date_config" />
                </div>
                <div class="w-1/2">
                    <x-mary-datepicker label="Data fim" wire:model="date_end" icon-right="o-calendar"
                        :config="$date_config" />
                </div>
            </div> --}}
            <div class="font-semibold">Áreas</div>
            <div class="flex flex-wrap gap-2">
                @foreach ($evento_areas as $area)
                    <x-mary-checkbox :id="'fill_area_' . $area->id" :label="$area->name" wire:model="fil_area_ids"
                        :value="$area->id" />
                @endforeach
            </div>

            {{-- <div class="flex flex-col">
                <label for="fil_area_ids" class="label label-text font-semibold">Áreas</label>
                <select  wire:model="fil_area_ids" class=" border-primary rounded-lg" multiple>
                    @foreach ($evento_areas as $area)
                        <option value="{{$area->id}}" class="">{{$area->name}}</option>
                    @endforeach
                </select>
            </div> --}}
            <x-slot:actions>
                <x-mary-button label="Limpar" @click="$wire.limpaFiltros()" />
                <x-mary-button label="Filtrar" type="submit" icon="o-check" class="btn-primary" />
            </x-slot:actions>
        </x-mary-form>
    </x-mary-drawer>

    @push('styles')
        {{-- Flatpickr  --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    @endpush
    @push('scripts')
        {{-- Flatpickr  --}}
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://npmcdn.com/flatpickr/dist/l10n/pt.js"></script>
    @endpush


    @script
        <script>
            document.getElementById('openReportPdf').addEventListener('click', function() {

                const var_link = "evento/pdf?" + "mes=" + $wire.fil_mes + "&grupo=" + $wire.fil_grupo + "&local=" +
                    $wire.fil_local + "&area_ids=" + $wire.fil_area_ids;
                console.log(var_link);
                window.open(var_link, '_blank');
            })
            /* document.getElementById('pdf').addEventListener('click', function(){
                //console.log('TEST');
                const var_link = "evento/calendar?" + "mes=" + $wire.fil_mes + "&grupo=" + $wire.fil_grupo + "&local=" + $wire.fil_local + "&area=" + $wire.fil_area;
                //console.log(var_link);
                window.open(var_link, '_blank');
                //$this->redirectRoute('evento.calendar', ['mes' => $this->fil_mes,'local' => $this->fil_local,'grupo' => $this->fil_grupo]);
            }) */
        </script>
    @endscript
</div>
