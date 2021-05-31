<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Redirect;
use App\User;
use App\Extracurricular;
use App\Student;
use App\Member;
use App\Achievement;
use App\Activity;


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
        $extracurriculars = Extracurricular::all();
        $extracurricular = Extracurricular::find($user->extracurricular_id);
       
        if($user->role == "ADMIN"){
            return view('homepage/homeAdmin',compact('extracurriculars'));
        }
        else if($user->role == "Kesiswaan"){
            $activities = Activity::where('confirm','=',"Confirmed")->orderBy('date','desc')->orderBy('extracurricular_id','asc')->get(); 
            $achievements = Achievement::where('confirm','=',"Confirmed")->orderBy('date','desc')->orderBy('extracurricular_id','asc')->get(); 
            $members = Member::where('status','!=',"Tidak Aktif")->orderBy('status','asc')->orderBy('extracurricular_id','asc')->get(); 

            return view('homepage/homeKesiswaan',compact('extracurriculars','user','achievements', 'activities', 'members'));
        }else{
           
            $students = DB::select("
            SELECT
                students.* 
            FROM
                students
                LEFT JOIN extracurricular_student ON extracurricular_student.student_id = students.id 
            WHERE
                NOT EXISTS ( SELECT * FROM extracurricular_student WHERE extracurricular_student.student_id = students.id AND extracurricular_id LIKE '".$extracurricular->id."' );"
            );
            $activities = Activity::where('extracurricular_id','=',$extracurricular->id)->orderBy('date','desc')->get(); 
            $members = Member::where('extracurricular_id','=',$extracurricular->id)->orderBy('angkatan','asc')->get(); 
            $activeMember = Member::where([['extracurricular_id','=',$extracurricular->id],['status','=','Aktif']])->count(); 
            $pembinaCount = User::where([['extracurricular_id','=',$extracurricular->id],['role','=','Pembina']])->count();
            $pembinas = User::where([['extracurricular_id','=',$extracurricular->id],['role','=','Pembina']])->get();
            $achievements = Achievement::where('extracurricular_id','=',$extracurricular->id)->orderBy('date','desc')->get(); 
            return view('homepage/home',compact('extracurricular','user','students','members','achievements', 'activities', 'activeMember', 'pembinas', 'pembinaCount'));
        }
        
    }

    public function detailKesiswaan($id){
        $user = Auth::user();
        if($user->role != "Kesiswaan"){
            return Redirect::route('home');
        }
        $extracurricular = Extracurricular::find($id);
        $students = Student::all();
        $activities = Activity::where([['confirm', '=','Confirmed'],['extracurricular_id','=',$extracurricular->id]])->orderBy('date','desc')->get(); 
        $members = Member::where('extracurricular_id','=',$extracurricular->id)->orderBy('angkatan','asc')->get();
        $activeMember = Member::where([['extracurricular_id','=',$extracurricular->id],['status','=','Aktif']])->count(); 
        $pembinas = User::where([['extracurricular_id','=',$extracurricular->id],['role','=','Pembina']])->get();
        $achievements = Achievement::where('extracurricular_id','=',$extracurricular->id)->orderBy('date','desc')->get();
        return view('homepage/home',compact('extracurricular','user','members','achievements', 'activities','students', 'activeMember', 'pembinas'));
    }
}
