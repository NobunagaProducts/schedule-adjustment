<?php


namespace App\Service;


use App\Event;
use App\PossibleDate;
use Exception;
//use http\Client\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Party
{
    
    public function addEvent(Request $request)
    {
        DB::beginTransaction();
        try {
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
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect('error');
        }
        return $event->hash_value;
    }
    
    public function editEvent(Request $request)
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
    
            $event = Array();
            foreach ($request->possible_dates as $date) {
                $event[] =
                    array('event_id' => session('event_info')['event_id'],
                        'possible_dates' => $date,
                    );
            }
            
            $created_date_count = PossibleDate::insert($event);
    
            if (!($updated_event_count == 1 && $deleted_date_count >= 1 && $created_date_count === true)) {
                throw new Exception('イベント編集時にエラー発生。' . ' イベント変更数:' . $updated_event_count . ' 候補日削除数' . $deleted_date_count . '作成候補日数' . $created_date_count);
            }
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('error');
        }
    }
}
