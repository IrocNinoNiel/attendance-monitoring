<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // tweets = Tweet::orderBy('created_at','DESC')->get();

        if(Auth::user()->user_type == 'user'){
            $attendance = Attendance::where('user_id','=',Auth::user()->id)
                ->orderBy('created_at','DESC')
                ->get();

            return view('home')->with('attendances',$attendance);
        }

        $attendance = Attendance::orderBy('created_at','DESC')->get();
        return view('home')->with('attendances',$attendance);
    }
}
