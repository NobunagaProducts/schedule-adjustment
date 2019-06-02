<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Event;
use App\PossibleDate;
use Exception;

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
            foreach ($request->possible_dates as $date) {
                $possible_date = new PossibleDate;
                $possible_date->event_id = $event->id;
                $possible_date->possible_dates = $date;
                $possible_date->save();
            }
            return $event->hash_value;
        }, 5);
        
        return redirect('event/info/' . $url_param);
    }
    
    public function showInfo($hash_value)
    {
        //todo:イベントが取得できなかった時の処理を追加。
        $event = Event::where('hash_value', $hash_value)->first();
        $possible_dates = PossibleDate::select('possible_dates')->where('event_id', $event->id)->get();
        $param =
            ['event_id' => $event->id,
                'event_name' => $event->event_name,
                'detail' => $event->detail,
                'created_at' => $event->created_at,
                'possible_date' => $possible_date->possible_dates];
        
        session(['hash_value', $hash_value]);
        session(['event_info' => $param]);
        
        return view('event_information', $param);
    }
    
    public function showEditInfo()
    {
        $param = [
            'event_name' => session('event_info')['event_name'],
            'detail' => session('event_info')['detail'],
            'possible_date' => session('event_info')['possible_date'],
        ];
        return view('event_edit', $param);
    }
    
    public function edit(Request $request)
    {
        DB::beginTransaction();
        try {
            $updated_event_count = Event::where('id', session('event_info')['event_id'])
                ->update([
                    'event_name' => $request->event_name,
                    'detail' => $request->detail,
                ]);
            
            $deleted_date_count = PossibleDate::where('event_id', session('event_info')['event_id'])
                ->delete();
            
            $created_date_count = PossibleDate::insert([
                'event_id' => session('event_info')['event_id'],
                'possible_dates' => $request->possible_date,
            ]);
            
            if (!($updated_event_count == 1 && $deleted_date_count >= 1 && $created_date_count === true)) {
                throw new Exception('イベント編集時にエラー発生。');
            }
            
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect('error');
        }
        // todo: ハッシュ値の場所がおかしいので調査。理想:session('hash_value')
        return redirect('event/info/' . session(1));
    }
    
    public function delete()
    {
    }
    
    
}
