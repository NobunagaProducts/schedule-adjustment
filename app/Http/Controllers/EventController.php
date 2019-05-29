<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Event;
use App\PossibleDate;

class EventController extends Controller
{
    
    public function create(Request $request)
    {

        $url_param = DB::transaction(function () use ($request) {
            // イベント追加
            $event = new Event;
            $event->event_name = $request->event_name;
            $event->detail = $request->detail;
            $event->hash_value = Str::random(30);
            $event->save();
    
            // 候補日追加
            // todo:TOP画面での複数日程のデザインと取得を考える。とりあえず日付は一つ
            $possible_date = new PossibleDate;
            $possible_date->event_id = $event->id;
            $possible_date->possible_dates = $request->possible_dates;
            $possible_date->save();
            return $event->hash_value;
        }, 5);
        // compactで$url_paramを渡す。
        return redirect('event/info/'.$url_param);
    }
    
    public function showInfo($hash_value)
    {
        $event = Event::where('hash_value', $hash_value)->first();
        $possible_date = PossibleDate::where('event_id', $event->id)->first();
        $param =
            ['event_name' => $event->event_name,
            'detail' => $event->detail,
            'created_at' => $event->created_at,
            'possible_date' => $possible_date->possible_dates];
        
        session(['hash_value', $hash_value]);
        session(['event_info' => $param]);
        
        return view('event_information', $param);
    }
    
    public function showEditInfo()
    {
        return view('event_edit');
    }
    
    public function edit()
    {
        $param = [
            'event_name' => session('event_info')['event_name'],
            'detail' => session('event_info')['detail'],
            'possible_date' => session('event_info')['possible_date'],
        ];
        return view('event_edit', $param);
    }
    
    public function delete()
    {
    }
    
    
}
