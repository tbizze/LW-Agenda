<div>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
    <div wire:ignore id='calendar'></div>

    <script>
        document.addEventListener('livewire:initialized', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                timeZone: 'America/Sao_Paulo',
                locale: "pt-br",
                editable: true,
                selectable: true,
                events: @json($events),
            });
            calendar.render();
        });
    </script>
</div>
