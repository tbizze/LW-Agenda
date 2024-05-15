<div>
    
    <div wire:ignore id='calendar'></div>

    {{-- Estes scripts serão inseridos nesta cláusula do layout. --}}
    @push('scripts')
        {{-- <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script> --}}
        {{-- <script src='{{asset('imgs/index.global.min.js')}}'></script>
        <script src='{{asset('imgs/daygrid/index.global.min.js')}}'></script> --}}
        <script src='{{asset('storage/fullcalendar/core/index.global.min.js')}}'></script>
        <script src='{{asset('storage/fullcalendar/daygrid/index.global.min.js')}}'></script>

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
                    //height: 800,
                    editable: true,
                    selectable: true,
                    events: @json($events),
                });
                calendar.render();
            });
        </script>
    @endpush
</div>
