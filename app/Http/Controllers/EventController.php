<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Facades\Party;

class EventController extends Controller
{
    public function create(Request $request)
    {
        return redirect('event/info/' . Party::addEvent($request));
    }
    
    public function showInfo($hash_value)
    {
        $param = Party::showInfo($hash_value);
        
        session(['hash_value', $hash_value]);
        session(['event_info' => $param]);
        
        return view('contents/event_information', $param);
    }
    
    public function showEditInfo()
    {
        $possible_dates = Array();
        
        foreach (session('event_info')['possible_dates'] as $date) {
            $possible_dates[] = Carbon::parse($date)->format('Y-m-d\TH:i');
        }
        
        $param = [
            'event_name' => session('event_info')['event_name'],
            'detail' => session('event_info')['detail'],
            'possible_dates' => $possible_dates,
        ];
        return view('contents/event_edit', $param);
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
