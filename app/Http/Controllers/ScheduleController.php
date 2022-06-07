<?php

namespace App\Http\Controllers;

use App\Models\Method;
use App\Models\Month;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $data['schedules'] = Schedule::all();
        $data['methods'] = Method::all();
        $data['months'] = Month::orderBy('number')->get();
   
        return view('schedules',$data);
    }

    public function getindex()
    {
        $data['schedules'] = Schedule::all();
        $data['methods'] = Method::all();
        $data['months'] = Month::orderBy('number')->get();
   
        return response()->json(['code'=>200, 'message'=>'Month added successfully','data' => $data], 200);
    }
    
    public function store(Request $request)
    {
        Schedule::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'method_id' => $request->method_id,
                'name' => $request->name,
                'date_start' => $request->date_start,
                'date_end' => $request->date_end,
            ]
        );
    
        return response()->json(['success' => true]);
    }
    
    public function edit(Request $request)
    {   
        $where = array('id' => $request->id);
        $schedule  = Schedule::where($where)->first();
 
        return response()->json($schedule);
    }
    
    public function destroy(Request $request)
    {
        $schedule = Schedule::where('id',$request->id)->delete();
   
        return response()->json(['success' => true]);
    }

    public function restore($id)
    {
        Schedule::withTrashed()->find($id)->restore();
  
        return response()->json(['success' => true]);
    }  

    public function restoreAll()
    {
        Schedule::onlyTrashed()->restore();
  
        return response()->json(['success' => true]);
    }
}
