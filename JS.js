    <!-- for fullcalendar -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@5.1.0/main.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@5.1.0/main.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            var Calendar = FullCalendar.Calendar;
            var Draggable = FullCalendar.Draggable;
            var containerEl = document.getElementById('external-events');
            var calendarEl = document.getElementById('calendar');

            // initialize the external events
            // -----------------------------------------------------------------

            new Draggable(containerEl, {
                itemSelector: '.fc-event',
                eventData: function(eventEl) 
                {                
                    return {
                        title: eventEl.innerText,                    
                        duration: { hours: 159 },
                        startTime: '17:30:00',
                        setAllDay: false,
                        timeZone:'UTC',

                    };
                }
            });
            var calendar = new Calendar(calendarEl, {
                // dateClick: function() {
                //     alert('a day has been clicked!');
                // },
                //timeZone: 'UTC',
                height: '500px',
                initialView: 'resourceTimelineMonth',
                headerToolbar: {
                    left: 'today prev,next',                    
                    right: 'title'
                },
                eventTimeFormat: { hour12: false, hour: '2-digit', minute: '2-digit' },
                businessHours: {
                    // days of week. an array of zero-based day of week integers (0=Sunday)
                    daysOfWeek: [ 1, 2, 3, 4,5 ], // Mon - Fri
                    startTime: '08:30', 
                    endTime: '17:30', 
                },
                slotLabelFormat: [
                    { month: 'long', year: 'numeric' }, // top level of text
                    { weekday: 'short',day:'numeric' } // lower level of text
                ],
                eventDrop: function() {
                    alert('Yerrp! - eventDrop');
                },
                eventReceive: function (eventEl) {
                    // eventEl.setAllDay(false, {maintainDuration: true})
                    // this.eventService.addEvent(eventEl);
                    //alert('Hooo! - eventReceive');                     
                    console.log('ID: ', $(this).attr('resource_id'));
                    console.log('Data-Events: ', eventEl.event.resourceId); 
                    var resources = eventEl.event.getResources(); 
                    var resourceIds = resources.map(function(resource) { return resource.id });
                    console.log('Resource: ', resourceIds);

                    $.ajax({
                        url: "http://ipioss.absoftware.se/fullcalendar/create",
                        data: 'title=' + eventEl.event.title + '&start=' + eventEl.event.start + '&end=' + eventEl.event.end + '&resources=' + resourceIds,
                        //data: 'title="test title"&start="2020-07-01 10:00:00"&end="2020-07-01 11:00:00"',
                        type: "POST",
                        success: function(info) {
                            console.log('Yep');
                        },
                        failure: function(info, status, exception) {
                            console.log('Nope!');
                        }
                    });

                },
                defaultAllDay: false,
                editable: true,
                resourceAreaHeaderContent: 'Departments',
                resources: [
                    { id: '1', title: 'ACM/WFO Engineer' },
                    { id: '2', title: 'IPO Engineer' },
                    { id: '3', title: 'ITS Engineer' },
                    { id: '4', title: 'AACC/ACCS Engineer' },
                    { id: '5', title: 'CTI Engineer' },
                    { id: '6', title: 'Duty Manager' },
                ],
                //events: '[{"id":1,"title":"Darren Round","start":"2020-07-03 17:30:00","end":"2020-07-10 17:30:00","resourceId":1,"is_paid_standby":1,"is_paid_overtime":1,"extra_parameters":null,"resource_id":1,"created_by_resource_id":null,"resourceId":null,"comments":null,"created_at":null,"updated_at":null},{"id":2,"title":"Mick Lee","start":"2020-07-10 17:30:00","end":"2020-07-17 17:30:00","is_paid_standby":1,"is_paid_overtime":1,"extra_parameters":null,"resource_id":1,"created_by_resource_id":null,"resourceId":null,"comments":null,"created_at":null,"updated_at":null}]'
                events: {
                    url: 'http://ipioss.absoftware.se/fullcalendar/events',
                    method: 'GET',

                    failure: function() {
                        alert('there was an error while fetching events!');
                    },
                    // color: 'yellow',   // a non-ajax option
                    // textColor: 'black' // a non-ajax option
                },
                displayEventTime: true,
                displayEventEnd: true,
                nextDayThreshold: '12:00:00',
                resourceAreaWidth: '20%',
                nowIndicator: true

            });
            calendar.render();
        });  
    </script>
    <!-- END OF Fulcalendar -->
