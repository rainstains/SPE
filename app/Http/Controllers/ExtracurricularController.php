<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use File;
use Redirect;
use App\Extracurricular;
use App\Student;
use App\Member;
use Illuminate\Support\Facades\Validator;

class ExtracurricularController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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

    public function add_member(Request $request){
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

    public function edit_member(Request $request){
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

}
