<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Ekstrakurikuler;

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
        $user = Auth::user();
        $ekskuls = Ekstrakurikuler::all();
        $ekskul = Ekstrakurikuler::find($user->ekskul_id);
        
        if($user->role == "ADMIN"){
            return view('homepage/homeAdmin',compact('ekskuls'));
        }
        else if($user->role == "Kesiswaan"){
            return view('homepage/homeKesiswaan',compact('ekskuls'));
        }else{
            return view('homepage/home',compact('ekskul','user'));
        }
        
    }
}
