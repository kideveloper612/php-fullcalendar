<!DOCTYPE html>
<html>
<head>
    <title>Laravel | Fullcalender</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
<link rel="stylesheet" href='https://cdn.jsdelivr.net/npm/fullcalendar@5.1.0/main.min.css' />
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

    </div>
 
    <div id='calendar-container'>
        <div id='calendar'></div>  
    </div>
 
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.1.0/main.min.js'></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var Draggable = FullCalendar.Draggable;
        var containerEl = document.getElementById('external-events');
        var calendarEl = document.getElementById('calendar');
        var checkbox;

        var SITEURL = "{{url('/')}}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: SITEURL + '/fullcalendar/event',
        })
        .then((data) => {
            data.forEach(ele => {
                const diffDays = Math.ceil(Math.abs(new Date(ele.end) - new Date(ele.start)) / (1000 * 60 * 60 * 24));
                let json = JSON.stringify({"id": ele.id, "title": ele.title, "duration": { "days": diffDays }});
                $('#external-events').append(`<div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event' data-event='${json}'><div class='fc-event-main'>${ele.title}</div></div>`)
            });
            $('#external-events').append(`<p><input type='checkbox' id='drop-remove' /><label for='drop-remove'>remove after drop</label></p>`);
            checkbox = document.getElementById('drop-remove');
        })
        .catch((err) => {
            console.log(err);
        });

        new Draggable(containerEl, {
            itemSelector: '.fc-event',
            eventData: function(event) {
                let eventData = JSON.parse(event.getAttribute('data-event'));
                return {
                    id: eventData.id,
                    title: eventData.title,
                    duration: eventData.duration
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
            initialView: 'dayGridMonth',
            eventResizableFromStart: true,
            events: {
                url: SITEURL + '/fullcalendar/event'
            },
            select: function(eventObj) {
                var title = prompt('Event Title:');
                if (title) {
                    $.ajax({    
                        url: SITEURL + "/fullcalendar/create",
                        data: {
                            'title': title,
                            'start': eventObj.startStr,
                            'end': eventObj.endStr
                        },
                        type: "POST",
                        success: function (data) {
                            calendar.addEvent({
                                title: title,
                                start: eventObj.startStr,
                                end: eventObj.endStr,
                                allDay: true
                            });
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    });
                }
                calendar.unselect();
            },
            eventReceive: function (event) {
                let startDate = moment(event.event.start).format('YYYY-MM-DD HH:mm:ss');
                let endDate = moment(event.event.end).format('YYYY-MM-DD HH:mm:ss');
                $.ajax({
                    url: SITEURL + '/fullcalendar/update',
                    method: 'POST',
                    data: {
                        'id': event.event.id,
                        'title': event.event.title,
                        'start': startDate,
                        'end': endDate
                    },
                    success: function (data) {
                        console.log('Successfully updated!')
                    },
                    error: function (err) {
                        alert(err.responseJSON.message);
                    }
                });
                if (checkbox.checked) {
                    event.draggedEl.parentNode.removeChild(event.draggedEl);
                }
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
                        'end': endDate
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
                let id = event.event.id;
                $.ajax({
                    url: SITEURL + '/fullcalendar/update',
                    method: 'POST',
                    data: {
                        'id': event.event.id,
                        'title': event.event.title,
                        'start': startDate,
                        'end': endDate
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
        });

        function destory(id) {
            calendar.getEventById(id).remove();
        }

        calendar.render();

    });
</script>
</html>