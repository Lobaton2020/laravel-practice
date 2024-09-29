@extends('layouts.app')
@section("content")
<h3>Detalle salas</h3>
<div id="event-form">
    <input type="text" id="event-title" placeholder="Título del evento" required>
    <input type="datetime-local" id="event-start" placeholder="Fecha de inicio" required>
    <input type="datetime-local" id="event-end" placeholder="Fecha de fin" required>
    <button id="add-event-btn">Agregar Evento</button>
</div>

<div id="view-options">
    <button id="btn-day">Vista Diaria</button>
    <button id="btn-week">Vista Semanal</button>
    <button id="btn-month">Vista Mensual</button>
</div>
<div id="calendar"></div>

<script defer>
    const calendar = new tui.Calendar('#calendar', {
        defaultView: 'month',
        useDetailPopup: true,
        useCreationPopup: true,
        useFormPopup: true,

        template: {
            monthDayname: function (dayname) {
                return '<span class="calendar-week-dayname-name">' + dayname.label + '</span>';
            }
        }
    });
    $('#btn-day').on('click', function () {
        calendar.changeView('day');
    });

    $('#btn-week').on('click', function () {
        calendar.changeView('week');
    });

    $('#btn-month').on('click', function () {
        calendar.changeView('month');
    });
    calendar.createEvents([
        {
            id: 'event1',
            calendarId: 'cal2',
            title: 'Weekly meeting',
            start: '2024-09-07T09:00:00',
            end: '2024-09-07T10:00:00',
        },
        {
            id: 'event2',
            calendarId: 'cal1',
            title: 'Lunch appointment',
            start: '2024-09-08T12:00:00',
            end: '2024-09-08T13:00:00',
        },
        {
            id: 'event3',
            calendarId: 'cal3',
            title: 'Vacation',
            start: '2024-09-08',
            end: '2024-09-10',
            isAllday: true,
            category: 'allday',
        },
    ]);
    calendar.on('beforeCreateEvent', function (event) {
        console.log({ event });
        const start = new Date(event.start.d.d);
        const end = new Date(event.end.d.d);

        const newEvent = {
            id: String(Math.random()),
            calendarId: '1',
            title: event.title ?? 'Sin título',
            category: 'time',
            start: start,
            end: end,
            location: event.location ?? '',
            isAllday: event.isAllday,
            isPrivate: event.isPrivate,
            state: event.state ?? 'Busy'
        };

        calendar.createEvents([newEvent]);
        calendar.render();
    });



    calendar.on('beforeUpdateEvent', function (event) {
        const { event: schedule, changes } = event;
        calendar.updateEvent(schedule.id, schedule.calendarId, changes);
        calendar.render();
    });
    calendar.on('beforeUpdateEvent', function (event) {
        const { event: schedule, changes } = event;
        calendar.updateEvent(schedule.id, schedule.calendarId, changes);
    });

    calendar.on('beforeDeleteEvent', function (event) {
        console.log(event)
        const { id, calendarId } = event;
        const confirmDelete = confirm("¿Estás seguro de que quieres eliminar este evento?");
        if (confirmDelete) {
            calendar.deleteEvent(id, calendarId);
        }
    });

    calendar.on('beforeUpdateSchedule', function (event) {
        const { schedule, changes } = event;
        calendar.updateSchedule(schedule.id, schedule.calendarId, changes);
    });
</script>
@endsection