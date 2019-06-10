<?php


namespace App\Service;


use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Party;
use App\PossibleDate;

class PartyService
{
    public function addEvent(Request $request)
    {
        DB::beginTransaction();
        try {
            // イベント追加
            $party = new Party;
            $party->event_name = $request->event_name;
            $party->detail = $request->detail;
            $party->hash_value = Str::random(30);
            $party->save();
            foreach ($request->possible_dates as $date) {
                $possible_date = new PossibleDate;
                $possible_date->event_id = $party->id;
                $possible_date->possible_dates = $date;
                $possible_date->save();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('error');
        }
        return $party->hash_value;
    }
    
    public function showInfo($hash_value)
    {
        //todo:イベントが取得できなかった時の処理を追加。
        $party = Party::where('hash_value', $hash_value)->first();
        $possible_dates = PossibleDate::select('possible_dates')->where('event_id', $party->id)->get()->toArray();
        $dates = array();
        
        // 候補日をセッションで使いやすいよう整形
        foreach ($possible_dates as $date) {
            $dates[] = $date['possible_dates'];
        }
        
        $param =
            ['event_id' => $party->id,
                'event_name' => $party->event_name,
                'detail' => $party->detail,
                'created_at' => $party->created_at,
                'hash_value' => $party->hash_value,
                'possible_dates' => $dates,
            ];
        
        return $param;
    }
    
    public function editEvent(Request $request)
    {
        DB::beginTransaction();
        try {
            $updated_event_count = Party::where('id', session('event_info')['event_id'])
                ->update([
                    'event_name' => $request->event_name,
                    'detail' => $request->detail,
                ]);
            
            $deleted_date_count = PossibleDate::where('event_id', session('event_info')['event_id'])
                ->delete();
            
            $party = Array();
            foreach ($request->possible_dates as $date) {
                $party[] =
                    array('event_id' => session('event_info')['event_id'],
                        'possible_dates' => $date,
                    );
            }
            
            $created_date_count = PossibleDate::insert($party);
            
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
