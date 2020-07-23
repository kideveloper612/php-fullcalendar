@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h1>Standby Rota</h1>                
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif                    

                    <div class="row">
                        <div class="col-2 px-3" id='external-events'>
                            <p>
                              <strong>Available Engineers</strong>
                            </p>
                          
                            <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event p-1 mb-1'>
                              <!--  
                                    The data-event json inside the DIV doesnt work. This is my problem and the main reason why I need help :-) Take a look at the variables
                                    like "resource_id", these are real varibales in my project.                                  
                                    If you can build it so that Fullcalendar understands the json in the data-event string below that would be great. 
                                    Obviously, take a look at the project information for the other things we need working as well. Remember that each DIV needs to represent
                                    a block of time from Friday 17:30 until the following Friday at 08:30.  As soon as the dragable DIV is dropped onto the calender, the user can make it
                                    longer or shorter depending on what they need and the JS/Ajax should make the changes in the table.
                              -->

                              <div data-event='{"resource_id": "11223344","title": "Darren Round","startTime": "17:30:00","setAllDay": "false","timeZone": "UTC"}' class='fc-event-main'>Darren Round</div>
                            </div>
                            <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event p-1 mb-1'>
                              <div class='fc-event-main'>Jimmy George</div>
                            </div>
                            <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event p-1 mb-1'>
                              <div class='fc-event-main'>Nic Atkins</div>
                            </div>
                            <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event p-1 mb-1'>
                              <div class='fc-event-main'>Paul Hrynkiw</div>
                            </div>
                            <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event p-1 mb-1'>
                              <div class='fc-event-main'>Umed Ali</div>
                            </div>
                          
                        </div>

                        <div class="col-10" id='calendar'>
                        </div>
                    </div>
                    




                 

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
