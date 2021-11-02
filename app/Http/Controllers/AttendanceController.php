<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request){

      
        $attendance = Attendance::where('type','=',$request->type)
            ->where('user_id','=',Auth::user()->id)
            ->where('date','=',\Carbon\Carbon::now()->toDateString())
            ->get();

        if(count($attendance) != 0){
            return Redirect::route('home')->with('error','Error: Already set Time '.$request->type);
        }

        $attendance = new Attendance();

        $attendance->time = \Carbon\Carbon::now();
        $attendance->type = $request->type;
        $attendance->date = \Carbon\Carbon::now();
        $attendance->user_id = Auth::user()->id;

        $attendance->save();

        if($request->type == 'in'){ 
            return Redirect::route('home')->with('success','Set Time in');
        }
        return Redirect::route('home')->with('success','Set Time out');
    }

    public function find(Request $request)
    {
        $name = $request->searchQuery;

        $this->validate($request,[
            'searchQuery'=>'required',
        ]);
        
        // $user = User::query()->where('name','LIKE',"${$name}")->get();
        $user = DB::table('users')->where('name','LIKE','%'.$name.'%')->get();

        if(count($user) == 0){
            $attendance = Attendance::where('user_id','=',0)
            ->get();
            return Redirect::route('home')->with('error','Employee Not Found')->with('attendances',$attendance);
        }

        $attendance = Attendance::where('user_id','=',$user[0]->id)
            ->get();

        return view('home')->with('attendances',$attendance);

    }
}
