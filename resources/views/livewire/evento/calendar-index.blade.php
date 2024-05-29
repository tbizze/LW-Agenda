<div>
    <div id='calendar' wire:ignore></div>

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

    @push('styles')
        {{-- Flatpickr  --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    @endpush
    {{-- Estes scripts serão inseridos nesta cláusula do layout. --}}
    @push('scripts')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
        {{-- <script src='{{asset('imgs/index.global.min.js')}}'></script>
        <script src='{{asset('imgs/daygrid/index.global.min.js')}}'></script> --}}
        {{-- <script src='{{asset('storage/fullcalendar/core/index.global.min.js')}}'></script>
        <script src='{{asset('storage/fullcalendar/daygrid/index.global.min.js')}}'></script> --}}

        {{-- Flatpickr  --}}
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://npmcdn.com/flatpickr/dist/l10n/pt.js"></script>

        <script>
            document.addEventListener('livewire:initialized', function() {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    buttonText: {
                        today: 'Hoje',
                    },
                    initialView: 'dayGridMonth',
                    timeZone: 'America/Sao_Paulo',
                    locale: "pt-br",
                    height: 800,
                    editable: true, // Determina se os eventos do calendário podem ser modificados.
                    selectable: true, // Permite que um usuário destaque vários dias ou intervalos de tempo clicando e arrastando.
                    fixedWeekCount: false, // Se true, haverá sempre 6 semanas. Se false, haverá 4, 5 ou 6 semanas.
                    //firstDay: 1, // O dia em que cada semana começa: 0 = domingo, 1 = segunda, etc.
                    eventTimeFormat: { // like '14:30:00'
                        hour: '2-digit',
                        minute: '2-digit',
                        //second: '2-digit',
                        meridiem: false, // AM ou PM.
                    },
                    events: @json($events),

                    // Método ao arrastar um evento do calendário.
                    eventDrop: function(data) {
                        @this.eventDrop(data.event, data.oldEvent);
                    },

                    // Método ao clicar em um evento do calendário.
                    eventClick: function(data) {
                        @this.eventEdit(data.event.id);
                    },

                    // Método ao selecionar uma data ou período, do calendário.
                    select: function(data) {

                        //@this.newEvent(data.start.toISOString(), data.end.toISOString())
                        //$wire.start_date = data.startStr;
                        //$wire.set('start_date', data.startStr);
                        //console.log($wire.start_date);

                        //console.log(data.startStr, data.endStr);
                        @this.newEvent(data.startStr, data.endStr)
                            .then(
                                function(event) {
                                    console.log(event);
                                    //         calendar.addEvent({
                                    //             id: id,
                                    //             title: 'event_name',
                                    //             start: data.startStr,
                                    //             end: data.endStr,
                                    //         });
                                    //         calendar.unselect();
                                });
                    },
                });
                calendar.render();
                // Livewire.on('refreshCalendar', function() {
                //     calendar.refetchEvents();
                // });
            });
        </script>
    @endpush
</div>
