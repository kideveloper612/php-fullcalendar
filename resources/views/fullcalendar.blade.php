<!DOCTYPE html>
<html>
<head>
    <title>Laravel | Fullcalender</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
<link rel="stylesheet" href='https://cdn.jsdelivr.net/npm/fullcalendar@5.1.0/main.min.css' />
<link rel="stylesheet" href='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@5.1.0/main.min.css' />
<style>

    html, body {
        margin: 0;
        padding: 0;
        font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
        font-size: 14px;
    }

    #external-events {
        position: fixed;
        z-index: 2;
        top: 20px;
        left: 20px;
        width: 150px;
        padding: 0 10px;
        border: 1px solid #ccc;
        background: #eee;
    }

    .demo-topbar + #external-events { /* will get stripped out */
        top: 60px;
    }

    #external-events .fc-event {
        cursor: move;
        margin: 3px 0;
    }

    #calendar-container {
        position: relative;
        z-index: 1;
        margin-left: 200px;
    }

    #calendar {
        max-width: 1100px;
        margin: 20px auto;
    }

    .fc-event-time {
        display : none!important;
    }

</style>

<body>

    <div id='external-events'>
        <p>
            <strong>Draggable Events</strong>
        </p>

        <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event p-1 mb-1'>
            <div data-event='{"title": "Darren Round","start": "2020-07-03 17:30:00","setAllDay": "false","timeZone": "UTC","resource_id": "1111"}' class='fc-event-main'>Darren Round</div>
        </div>
        <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event p-1 mb-1'>
            <div data-event='{"title": "Jimmy George","start": "2020-07-10 17:30:00","setAllDay": "false","timeZone": "UTC","resource_id": "2222"}' class='fc-event-main'>Jimmy George</div>
        </div>
        <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event p-1 mb-1'>
            <div data-event='{"title": "Nic Atkins","start": "2020-07-03 17:30:00","setAllDay": "false","timeZone": "UTC","resource_id": "3333"}' class='fc-event-main'>Nic Atkins</div>
        </div>
        <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event p-1 mb-1'>
            <div data-event='{"title": "Paul Hrynkiw","start": "2020-07-03 17:30:00","setAllDay": "false","timeZone": "UTC","resource_id": "4444"}' class='fc-event-main'>Paul Hrynkiw</div>
        </div>
        <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event p-1 mb-1'>
            <div data-event='{"title": "Umed Ali","start": "2020-07-13 17:30:00","setAllDay": "false","timeZone": "UTC","resource_id": "5555"}' class='fc-event-main'>Umed Ali</div>
        </div>

    </div>
 
    <div id='calendar-container'>
        <div id='calendar'></div>  
    </div>
 
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.1.0/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@5.1.0/main.min.js'></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var Draggable = FullCalendar.Draggable;
        var containerEl = document.getElementById('external-events');
        var calendarEl = document.getElementById('calendar');
        var checkbox;

        var SITEURL = "{{url('/')}}";
        var currentDate = localStorage.getItem('currentDate');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        new Draggable(containerEl, {
            itemSelector: '.fc-event',
            eventData: function(event) {
                let eventData = JSON.parse(event.children[0].getAttribute('data-event'));
                return {
                    title: eventData.title,
                    description: eventData.resource_id,
                    duration: { hours: 159 },
                    startTime: '17:30:00',
                    setAllDay: false,
                    timeZone:'UTC'
                };
            }
        });

        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prevYear,prev,next,nextYear today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek,dayGridDay'
            },
            selectable: true,
            navLinks: true,
            editable: true,
            droppable: true,
            dayMaxEvents: true,
            initialDate: currentDate,
            initialView: 'resourceTimelineMonth',
            eventResizableFromStart: true,
            events: SITEURL + '/fullcalendar/event',
            resourceAreaHeaderContent: 'Departments',
            resources: [
                { id: '1', title: 'ACM/WFO Engineer' },
                { id: '2', title: 'IPO Engineer' },
                { id: '3', title: 'ITS Engineer' },
                { id: '4', title: 'AACC/ACCS Engineer' },
                { id: '5', title: 'CTI Engineer' },
                { id: '6', title: 'Duty Manager' },
            ],
            eventReceive: function (event) {
                let startDate = moment(event.event.start).format('YYYY-MM-DD HH:mm:ss');
                let endDate = moment(event.event.end).format('YYYY-MM-DD HH:mm:ss');
                setCurrentDate();
                $.ajax({
                    url: SITEURL + '/fullcalendar/create',
                    method: 'POST',
                    data: {
                        'title': event.event.title,
                        'start': startDate,
                        'end': endDate,
                        'resourceId': event.event._def.resourceIds[0],
                        'resource_id': event.event._def.extendedProps.description
                    },
                    success: function (id) {
                        calendar.refetchEvents();
                        event.event.remove();
                    },
                    error: function (err) {
                        alert(err.responseJSON.message);
                    }
                });
            },
            eventDrop: function (event) {
                let startDate = moment(event.event.start).format('YYYY-MM-DD HH:mm:ss');
                let endDate = moment(event.event.end).format('YYYY-MM-DD HH:mm:ss');
                let id = event.event.id;
                $.ajax({
                    url: SITEURL + '/fullcalendar/update',
                    method: 'POST',
                    data: {
                        'id': event.event.id,
                        'title': event.event.title,
                        'start': startDate,
                        'end': endDate,
                        'resourceId': event.event._def.resourceIds[0]
                    },
                    success: function (data) {
                        console.log('Successfully updated!')
                    },
                    error: function (err) {
                        alert(err.responseJSON.message);
                    }
                });
            },
            eventResize: function (event) {
                let startDate = moment(event.event.start).format('YYYY-MM-DD HH:mm:ss');
                let endDate = moment(event.event.end).format('YYYY-MM-DD HH:mm:ss');
                console.log(event.event.id, startDate, endDate)
                let id = event.event.id;
                $.ajax({
                    url: SITEURL + '/fullcalendar/update',
                    method: 'POST',
                    data: {
                        'id': event.event.id,
                        'title': event.event.title,
                        'start': startDate,
                        'end': endDate,
                        'resourceId': event.event._def.resourceIds[0]
                    },
                    success: function (data) {
                        console.log('Successfully updated!')
                    },
                    error: function (err) {
                        alert(err.responseJSON.message);
                    }
                });
            },
            eventClick: function (event) {
                if (confirm('Are you sure to delete this event?')) {
                    $.ajax({
                        url: SITEURL + '/fullcalendar/delete',
                        method: 'POST',
                        data: {
                            'id': event.event.id
                        },
                        success: function (data) {
                            console.log('Successfully deleted!');
                            destory(event.event.id);
                        },
                        error: function (err) {
                            alert(err.responseJSON.message);
                        }
                    });
                }
            }
        });

        function destory(id) {
            calendar.getEventById(id).remove();
        }
        
        function setCurrentDate() {
            localStorage.setItem('currentDate', calendar.getDate().toISOString());
        }

        calendar.render();
    });

    
</script>
</html>