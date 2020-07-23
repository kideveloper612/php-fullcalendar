<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use Redirect,Response;
use Carbon\Carbon;

class OnCallController extends Controller
{
    public function test(){
        return view('rota.rotatest');
    }

    public function events(){
        $events = Event::all();
        return $events;
    }

    public function index()
    {
        if(request()->ajax()) 
        {
 
         $start = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
         $end = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');
 
         $data = Event::whereDate('start', '>=', $start)->whereDate('end',   '<=', $end)->get(['id','title','start', 'end']);
         dd($data);
         return Response::json($data);
        }
        return view('rota.fullcalendar');
    }
    
   
    public function create(Request $request)
    {  
        // Fullcalendar gives us this crap to deal with!
        // Thu Jul 02 2020 17:30:00 GMT 0200 (Central European Summer Time)
        $start = Carbon::parse(substr($request->start, 0, 24));
        $end = Carbon::parse(substr($request->end, 0, 24));
        $insertArr = [ 'title' => $request->title,
                       'start' => $start,
                       'end' => $end,
                       'resourceId' => $request->resources
                    ];
        dump($request);            
        dump($insertArr);
        $event = Event::insert($insertArr);   
        dump($event);
        return Response::json($event);
    }
     
 
    public function update(Request $request)
    {   
        $where = array('id' => $request->id);
        $updateArr = ['title' => $request->title,'start' => $request->start, 'end' => $request->end];
        $event  = Event::where($where)->update($updateArr);
 
        return Response::json($event);
    } 
 
 
    public function destroy(Request $request)
    {
        $event = Event::where('id',$request->id)->delete();
   
        return Response::json($event);
    }    
}
