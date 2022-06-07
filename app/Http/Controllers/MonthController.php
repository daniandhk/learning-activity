<?php

namespace App\Http\Controllers;

use App\Models\Month;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonthController extends Controller
{
    public function index()
    {
        $data['months'] = Month::all()
                                ->sortBy(function ($item, $i) { 
                                            return ( Carbon::parse($item->name)->format("m") );
                                        });
   
        return view('schedules',$data);
    }
    
    public function store(Request $request)
    {
        $month = Month::orderBy('number', 'DESC')->first();

        if($month->number == 12){
            return response()->json(['code'=>403, 'message'=>'Already reached 12 months!'], 403);
        }
        $check = Month::withTrashed()->where('number', ($month->number)+1)->first();
        if($check && $check->deleted_at != null){
            $check->restore();
            $new = $check;
        }
        else{
            $new = Month::withTrashed()->create(
                [
                    'number' => ($month->number)+1,
                ]
            );
        }
    
        return response()->json(['success' => true]);
    }
    
    public function edit(Request $request)
    {   
        $where = array('id' => $request->id);
        $month  = Month::where($where)->first();
 
        return response()->json($month);
    }
    
    public function destroy(Request $request)
    {
        $month = Month::orderBy('number', 'DESC')->first()->delete();
   
        return response()->json(['code'=>200, 'message'=>'Month deleted successfully','data' => $month], 200);
    }

    public function restore($id)
    {
        Month::withTrashed()->find($id)->restore();
  
        return response()->json(['success' => true]);
    }  

    public function restoreAll()
    {
        Month::onlyTrashed()->restore();
  
        return response()->json(['success' => true]);
    }
}
