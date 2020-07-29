<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Redirect,Response;
class FullCalendarController extends Controller
{
    public function index(Request $request)
    {
        return view('fullcalendar');
    }

    public function event(Request $request)
    {
        $start = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
        $end = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');
        if (!empty($_GET["start"]) && !empty($_GET["end"])) {
            $data = Event::whereDate('start', '>=', $start)->whereDate('end',   '<=', $end)->get(['id','title', 'start', 'end', 'resourceId']);
        } else if (!empty($_GET["start"])) {
            $data = Event::whereDate('start', '>=', $start)->get(['id','title','start', 'end', 'resourceId']);
        } else if (!empty($_GET["end"])) {
            $data = Event::whereDate('end',   '<=', $end)->get(['id','title','start', 'end', 'resourceId']);
        } else {
            $data = Event::all(['id','title','start', 'end', 'resourceId']);
        }
        return Response::json($data);
    }
    
   
    public function create(Request $request)
    {  
        $insertArr = [ 
                        'title' => $request->title,
                        'start' => $request->start,
                        'end' => $request->end,
                        'resourceId' => $request->resourceId,
                        'resource_id' => $request->resource_id
                    ];
        $event = Event::insertGetId($insertArr);
        return Response::json($event);
    }
     
 
    public function update(Request $request)
    {   
        $where = array('id' => $request->id);
        $updateArr = ['title' => $request->title,'start' =>  $request->start, 'end' => $request->end, 'resourceId' => $request->resource_id];
        $event  = Event::where($where)->update($updateArr);
 
        return Response::json($event);
    } 
 
 
    public function destroy(Request $request)
    {
        $event = Event::where('id',$request->id)->delete();
   
        return Response::json($event);
    }    
}
