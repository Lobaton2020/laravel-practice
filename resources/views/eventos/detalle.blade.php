@extends('layouts.app')
@section("content")
<style>

</style>
<h3>({{$sala->id}}){{$sala->nombre}} </h3>
<div id="view-optionss">
    <button class="btn btn-info btn-sm" id="btn-day">Vista Diaria</button>
    <button class="btn btn-info btn-sm" id="btn-week">Vista Semanal</button>
    <button class="btn btn-info btn-sm" id="btn-month">Vista Mensual</button>
</div>
<div id="menu" class="mt-2">
    <button class="btn btn-light rounded-pill border btn-sm" id="today">Today</button>
    <button class="btn btn-light rounded-pill border btn-sm" id="prev">&lt;</button>
    <button class="btn btn-light rounded-pill border btn-sm" id="next">&gt;</button>
    <strong><span class="ml-5 t-4" id="date-range"></span></strong>
</div>

<div id="calendar"></div>

<div id="global-loader" class="global-loader hidden">
    <div class="loader"></div>
    <p>Cargando...</p>
</div>
<script defer>

    // Loader
    function showLoader() {
        $('#global-loader').removeClass('hidden');
    }

    function hideLoader() {
        $('#global-loader').addClass('hidden');
    }

    $(document).on('loader:start', function () {
        showLoader();
    });

    $(document).on('loader:stop', function () {
        hideLoader();
    });
    //Fin loader
    const eventos = @json($sala->eventos);
    console.log({ eventos })
    const calendar = new tui.Calendar('#calendar', {
        defaultView: 'month',
        useDetailPopup: true,
        useCreationPopup: true,
        useFormPopup: true,
        usageStatistics: true,
        events: eventos.map(x => ({ calendarId: x.id, category: 'time', isAllDay: x.all_day, ...x })),
        template: {

            monthDayname: function (dayname) {
                return '<span class="calendar-week-dayname-name">' + dayname.label + '</span>';
            }
        }
    });
    calendar.createEvents(eventos);
    function updateDateRange() {
        const viewName = calendar.getViewName();
        let startDate, endDate;
        const monthNames = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];
        if (viewName === 'month') {
            const currentDate = calendar.getDate().toDate();
            const currentMonth = monthNames[currentDate.getMonth()];
            const currentYear = currentDate.getFullYear();
            $('#date-range').text(`${currentMonth} ${currentYear}`);


        } else if (viewName === 'week') {
            startDate = calendar.getDateRangeStart().toDate();
            endDate = calendar.getDateRangeEnd().toDate();
            $('#date-range').text(`${startDate.getFullYear()}.${String(startDate.getMonth() + 1).padStart(2, '0')}.${String(startDate.getDate()).padStart(2, '0')} ~ ${endDate.getFullYear()}.${String(endDate.getMonth() + 1).padStart(2, '0')}.${String(endDate.getDate()).padStart(2, '0')}`);
        } else if (viewName === 'day') {
            const currentDate = calendar.getDate().toDate();
            const currentMonth = monthNames[currentDate.getMonth()];
            const currentYear = currentDate.getFullYear();
            const currentDay = String(currentDate.getDate()).padStart(2, '0');

            $('#date-range').text(`${currentDay} ${currentMonth} ${currentYear}`);

        }
    }

    $('#today').on('click', function () {
        calendar.today();
        updateDateRange();
    });

    $('#prev').on('click', function () {
        calendar.prev();
        updateDateRange();
    });

    $('#next').on('click', function () {
        calendar.next();
        updateDateRange();
    });

    updateDateRange();

    $('#btn-day').on('click', function () {
        calendar.changeView('day');
        updateDateRange();
    });

    $('#btn-week').on('click', function () {
        calendar.changeView('week');
        updateDateRange();
    });

    $('#btn-month').on('click', function () {
        calendar.changeView('month');
        updateDateRange();
    });
    calendar.on('beforeCreateEvent', async function (event) {
        console.log({ event });
        const start = new Date(event.start.d.d);
        const end = new Date(event.end.d.d);

        const newEvent = {
            calendarId: '1',
            title: event.title ?? 'Sin título',
            category: 'time',
            start: start,
            end: end,
            location: event.location ?? '',
            isAllday: event.isAllday,
            isPrivate: event.isPrivate,
            state: event.state ?? 'Busy',
            id_sala: '{{$sala->id}}'
        };
        try {
            $(document).trigger('loader:start');
            const response = await fetch('/api/eventos', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(newEvent)
            });

            if (!response.ok) throw new Error('Error al guardar el evento');

            calendar.createEvents([newEvent]);
            calendar.render();
        } catch (error) {
            console.error(error);
        } finally {
            $(document).trigger('loader:stop');
        }

    });
    calendar.on('beforeUpdateEvent', async function (event) {
        const { event: schedule, changes } = event;
        const updatedEvent = {
            calendarId: schedule.calendarId,
            title: changes.title ?? schedule.title,
            category: 'time',
            start: changes.start ? new Date(changes.start.d.d) : new Date(schedule.start.d.d),
            end: changes.end ? new Date(changes.end.d.d) : new Date(schedule.end.d.d),
            location: changes.location ?? schedule.location,
            isAllday: changes.isAllday ?? schedule.isAllday,
            isPrivate: changes.isPrivate ?? schedule.isPrivate,
            state: changes.state ?? schedule.state,
            id_sala: '{{$sala->id}}'
        };

        try {
            $(document).trigger('loader:start');

            const response = await fetch(`/api/eventos/${schedule.id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(updatedEvent)
            });

            if (!response.ok) throw new Error('Error al actualizar el evento');
            calendar.updateEvent(schedule.id, schedule.calendarId, changes);
            calendar.render();
        } catch (error) {
            console.error(error);
        } finally {
            $(document).trigger('loader:stop');
        }
    });
    calendar.on('beforeDeleteEvent', async function (event) {
        console.log(event)
        const { id, calendarId } = event;
        const confirmDelete = confirm("¿Estás seguro de que quieres eliminar este evento?");
        if (confirmDelete) {
            try {
                $(document).trigger('loader:start');

                const response = await fetch(`/api/eventos/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                if (!response.ok) throw new Error('Error al eliminar el evento');
                calendar.deleteEvent(id, calendarId);
                calendar.render();
            } catch (error) {
                console.error('Error al eliminar el evento:', error);
            } finally {
                $(document).trigger('loader:stop');
            }
        }
    });
    calendar.on('beforeUpdateSchedule', function (event) {
        const { schedule, changes } = event;
        calendar.updateSchedule(schedule.id, schedule.calendarId, changes);
    });
</script>
@endsection