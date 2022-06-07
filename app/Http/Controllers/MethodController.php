<?php

namespace App\Http\Controllers;

use App\Models\Method;
use Illuminate\Http\Request;

class MethodController extends Controller
{
    public function index()
    {
        $data['methods'] = Method::all();
   
        return view('schedules',$data);
    }
    
    public function store(Request $request)
    {
        $method = Method::updateOrCreate(
                    [
                        'id' => $request->id
                    ],
                    [
                        'name' => $request->name,
                    ]);
    
        return response()->json(['success' => true]);
    }
    
    public function edit(Request $request)
    {   
        $where = array('id' => $request->id);
        $method  = Method::where($where)->first();
 
        return response()->json($method);
    }
    
    public function destroy(Request $request)
    {
        $method = Method::where('id',$request->id)->delete();
   
        return response()->json(['success' => true]);
    }

    public function restore($id)
    {
        Method::withTrashed()->find($id)->restore();
  
        return response()->json(['success' => true]);
    }  

    public function restoreAll()
    {
        Method::onlyTrashed()->restore();
  
        return response()->json(['success' => true]);
    }
}
