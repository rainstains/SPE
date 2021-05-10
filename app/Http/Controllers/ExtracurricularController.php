<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use File;
use Redirect;
use App\Extracurricular;
use App\Student;
use App\Member;
use App\Achievement;
use App\Activity;
use DB;
use Illuminate\Support\Facades\Validator;

class ExtracurricularController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Extracurricular
    public function create_ekskul(Request $request){
        $this->validate($request,[
            'name' => 'required',
            'dateEstablished' => 'required',
            'logo' => 'required|image|mimes:jpeg,jpg,png,svg',
        ]);
        
        $name = strtolower($request->name);
        $ifExists = Extracurricular::whereRaw('lower(name) like (?)',["%{$name}%"])->count();
        if ($ifExists > 0) {
            //udah ada
            return Redirect::back();
        }

        $extracurricular = Extracurricular::create([
            'name' => $request->name,
            'dateEstablished' => $request->dateEstablished,
            'logo' => $request->logo,
        ]);

        $logo = $request->file('logo');
        $filename = "logo_".$extracurricular ->id."_".$logo->getClientOriginalName();

        $dir_upload = "uploaded_files"."/"."Extracurricular/".$extracurricular ->id."/logo/";
        $logo->move($dir_upload, $filename);

        $extracurricular->logo = $filename;
        $extracurricular->save();

        return Redirect::back();
    }

    public function update_status_ekskul(Request $request){
        $extracurricular = Extracurricular::find($request->id);
        $extracurricular->status = $request->status;
        $extracurricular->save();
        return Redirect::back();
    }

    public function update_ekskul(Request $request){
        $extracurricular = Extracurricular::find($request->id);
        $this->validate($request,[
            'name' => 'required',
            'dateEstablished' => 'required',
        ]);

        if($request->logo != null){
            $this->validate($request,[
                'logo' => 'required|image|mimes:jpeg,jpg,png,svg',
            ]);
            
            File::Delete("uploaded_files"."/"."Extracurricular/".$extracurricular->id."/logo/".$extracurricular->logo);
            
            $logo = $request->file('logo');
            $filename = "logo_".$request->id."_".$logo->getClientOriginalName();

            $dir_upload = "uploaded_files"."/"."Extracurricular/".$request->id."/logo/";
            $logo->move($dir_upload, $filename);
            $extracurricular->logo = $filename;
        }
        $extracurricular->name = $request->name;
        $extracurricular->dateEstablished = $request->dateEstablished;
        $extracurricular->save();

        return Redirect::back();
    }

    public function delete_ekskul(Request $request){
        $extracurricular = Extracurricular::find($request->id);
        $extracurricular->delete();
        $dir_delete = "uploaded_files"."/"."Extracurricular/".$request->id;
        File::deleteDirectory(public_path($dir_delete));
        return Redirect::back();
    }

    //Member
    public function create_member(Request $request){
        $this->validate($request,[
            'angkatan' => 'required'
        ]);
    
        $extracurricular = Extracurricular::find($request->extracurricular_id);
        $student = Student::find($request->student_id);
        $member = Member::where([['student_id','=',$request->student_id],['extracurricular_id','=',$request->extracurricular_id]])->count();
        if ($member > 0) {
            return Redirect::back();
        }

        $student->extracurricular()->attach($request->extracurricular_id, ['status'=>"Aktif",'angkatan'=>$request->angkatan]);

        return Redirect::back();
    }

    public function update_member(Request $request){
        $this->validate($request,[
            'angkatan' => 'required',
            'status' => 'required',
        ]);

        $member = Member::find($request->id);
        $member->angkatan = $request->angkatan;
        $member->status = $request->status;
        $member->save();

        return Redirect::back();
    }

    public function delete_member(Request $request){
        $member = Member::find($request->id);
        $member->delete();

        return Redirect::back();
    }

    //Achievement
    public function create_achievement(Request $request){
        $this->validate($request,[
            'name' => 'required',
            'date' => 'required',
            'extracurricular_id' => 'required',
        ]);

        if ($request->statusPres == "Lainnya") {
            $this->validate($request,[
                'lainnya' => 'required',
            ]);
            $status = $request->lainnya;
        }else{
            $this->validate($request,[
                'statusPres' => 'required',
            ]);
            $status = $request->statusPres;
        }
        
        $name = strtolower($request->name);
        $ifExists = Achievement::whereRaw('lower(name) like (?)',["%{$name}%"])->where([['date','=',$request->date],['status','=',$status]])->count();
        if ($ifExists > 0) {
            //udah ada
            return Redirect::back();
        }else{
            $achievement = Achievement::create([
                'name' => $request->name,
                'date' => $request->date,
                'status' => $status,
                'extracurricular_id' => $request->extracurricular_id,
            ]);
        }
        
        return Redirect::back();
    }

    public function update_achievement(Request $request){
        $this->validate($request,[
            'name' => 'required',
            'date' => 'required',
            'id' => 'required',
        ]);

        if ($request->statusPres == "Lainnya") {
            $this->validate($request,[
                'lainnya' => 'required',
            ]);
            $statuss = $request->lainnya;
        }else{
            $this->validate($request,[
                'statusPres' => 'required',
            ]);
            $status = $request->statusPres;
        }
        
        $name = strtolower($request->name);

        $ifExists = Achievement::whereRaw('lower(name) like (?)',["%{$name}%"])->where([['date','=',$request->date],['status','=',$status]])->count();
        if ($ifExists > 0) {
            //udah ada
            return Redirect::back();
        }else{
            $achievement = Achievement::find($request->id);
            $achievement->name = $request->name;
            $achievement->date = $request->date;
            $achievement->status = $status;
            $achievement->save();
        }
        
        return Redirect::back();
    }

    public function delete_achievement(Request $request){
        $this->validate($request,[
            'id' => 'required',
        ]);
        $achievement = Achievement::find($request->id);
        $achievement->delete();
        return Redirect::back();
    }

    public function confirm_achievement(Request $request){
        $this->validate($request,[
            'confirm' => 'required',
            'id' => 'required',
        ]);
        $achievement = Achievement::find($request->id);
        $achievement->confirm = $request->confirm;

        $period = strtotime($achievement->date);
        $month = strtoupper(date("F",$period));
        $year = date("Y",$period);
        $period = substr($month,0,3).$year;

        $achievement->period = $period;
        $achievement->save();
        return Redirect::back();
    }

    //Activity
    public function create_activity(Request $request){
        $this->validate($request,[
            'nameAddAct' => 'required',
            'dateAddAct' => 'required',
            'extracurricular_id' => 'required',
        ]);

        $activity = Activity::create([
            'name' => $request->nameAddAct,
            'date' => $request->dateAddAct,
            'extracurricular_id' => $request->extracurricular_id,
        ]);

        if ($request->descAddAct != null) {
            $activity->desc = $request->descAddAct;
            $activity->save();
        }

        return Redirect::back();
    }

    public function confirm_activity(Request $request){
        $this->validate($request,[
            'confirmAct' => 'required',
            'id' => 'required',
        ]);
        
        $activity = Activity::find($request->id);
        $activity->confirm = $request->confirmAct;

        $period = strtotime($activity->date);
        $month = strtoupper(date("F",$period));
        $year = date("Y",$period);
        $period = substr($month,0,3).$year;

        $activity->period = $period;
        $activity->save();
        return Redirect::back();
    }

    public function update_activity(Request $request){
        $this->validate($request,[
            'id' => 'required',
            'nameEditAct' => 'required',
            'dateEditAct' => 'required',
        ]);

        if ($request->descEditAct != null) {
            $desc = $request->descEditAct;
        }else{
            $desc = "No Description";
        }

        $activity = Activity::find($request->id);
        $activity->name = $request->nameEditAct;
        $activity->date = $request->dateEditAct;
        $activity->desc = $desc;
        $activity->save();

        return Redirect::back();
    }

    public function delete_activity(Request $request){
        $this->validate($request,[
            'id' => 'required'
        ]);

        $activity = Activity::find($request->id);
        $activity->delete();

        return Redirect::back();
    }

    public function update_detail_activity(Request $request){
        $this->validate($request,[
            'id' => 'required',
            'photoEditDetailAct' => 'required|image|mimes:jpeg,jpg,png,svg',
            'extracurricular_id' => 'required',
        ]);
        
        $activity = Activity::find($request->id);
        $extracurricular = Extracurricular::find($activity->extracurricular_id);

        if ($activity->photo != null) {
            File::Delete("uploaded_files"."/"."Extracurricular/".$extracurricular->id."/Activity/photo/".$activity->photo);
        }else{           
            $photo = $request->file('photoEditDetailAct');
            $filename = "PhotoKegiatan_".$activity->id."_".$photo->getClientOriginalName();

            $dir_upload = "uploaded_files"."/"."Extracurricular/".$extracurricular->id."/Activity/photo/";
            $photo->move($dir_upload, $filename);
            $activity->photo = $filename;
        }

        $activity->save();
        
        return Redirect::back();
    }

    //Report belom kepake
    public function getReportAchievements($id){
        $extracurricular = Extracurricular::find($id);

        $achievements = Achievement::where([['status', '=','Confirmed'],['extracurricular_id','=',$extracurricular->id]])->orderBy('date','desc')->get();
        
        return $achievements;
    }

    public function getReportActivites($id){
        $extracurricular = Extracurricular::find($id);

        $activities = Activity::where([['status', '=','Confirmed'],['extracurricular_id','=',$extracurricular->id]])->orderBy('date','desc')->get();
        
        return $activities;
    }

    public function getReportAllAchievements(){
        
        $achievements = Achievement::where('status', '=','Confirmed')->orderBy('date','desc')->get();
        
        return $achievements;
    }

    public function getReportAllActivites(){
        $activities = Activity::where('status', '=','Confirmed')->orderBy('date','desc')->get();
        
        return $activities;
    }
}
