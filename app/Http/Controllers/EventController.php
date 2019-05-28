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
        return redirect('event/info?eventid='.$url_param);
    }
    
    public function showInfo()
    {
        return view('event_infomation');
    }
    
    public function showEditInfo()
    {
    }
    
    public function edit()
    {
    }
    
    public function delete()
    {
    }
    
    
}
