<?php

namespace App\Http\Controllers;

use App\Facades\Party;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Event;
use App\PossibleDate;
use Exception;

class EventController extends Controller
{
    
    public function create(Request $request)
    {
        return redirect('event/info/'.Party::addEvent($request));
    }
    
    public function showInfo($hash_value)
    {
        //todo:イベントが取得できなかった時の処理を追加。
        $event = Event::where('hash_value', $hash_value)->first();
        $possible_dates = PossibleDate::select('possible_dates')->where('event_id', $event->id)->get()->toArray();
        $dates  = array();
        
        // 候補日をセッションで使いやすいよう整形
        foreach ($possible_dates as $date){
            $dates[] = $date['possible_dates'];
        }

        $param =
            ['event_id' => $event->id,
                'event_name' => $event->event_name,
                'detail' => $event->detail,
                'created_at' => $event->created_at,
                'hash_value' => $event->hash_value,
                'possible_dates' => $dates,
            ];
        
        session(['hash_value', $hash_value]);
        session(['event_info' => $param]);
        
        return view('event_information', $param);
    }
    
    public function showEditInfo()
    {
        $possible_dates = Array();
        
        foreach (session('event_info')['possible_dates'] as $date){
             $possible_dates[] = Carbon::parse($date)->format('Y-m-d\TH:i');
        }
        
        $param = [
            'event_name' => session('event_info')['event_name'],
            'detail' => session('event_info')['detail'],
            'possible_dates' => $possible_dates,
        ];
        return view('event_edit', $param);
    }
    
    public function edit(Request $request)
    {
        Party::editEvent($request);
        return redirect('event/info/' . session('event_info')['hash_value']);
    }
    
    public function delete()
    {
    }
    
    
}
