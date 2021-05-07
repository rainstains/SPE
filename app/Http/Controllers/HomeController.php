<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Extracurricular;
use App\Student;
use App\Member;

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
        $students = Student::all();
        $extracurriculars = Extracurricular::all();
        $extracurricular = Extracurricular::find($user->extracurricular_id);
        
        
        if($user->role == "ADMIN"){
            return view('homepage/homeAdmin',compact('extracurriculars'));
        }
        else if($user->role == "Kesiswaan"){
            return view('homepage/homeKesiswaan',compact('extracurriculars','user'));
        }else{
            $members = Member::where('extracurricular_id','=',$extracurricular->id)->orderBy('angkatan','asc')->get(); 
            return view('homepage/home',compact('extracurricular','user','students', 'members'));
        }
        
    }
}
