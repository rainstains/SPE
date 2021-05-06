<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Extracurricular;
use Redirect;

class AddUserController extends Controller
{
    protected function create(Request $request)
    {
        $this->validate($request,[
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:12', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required'],
        ]);
        if($request->role == "Kesiswaan"){
            $extracurricular_id = NULL;
        }else{
            $extracurricular_id =$request->extracurricular_id;
        }
        
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'extracurricular_id' => $extracurricular_id,
        ]);
        
        return Redirect::back();
    }

    public function index(){
        $extracurriculars = Extracurricular::all();
        return view('/auth/register',compact('extracurriculars'));
    }
}
