<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use File;
use Redirect;
use App\Ekstrakurikuler;
use Illuminate\Support\Facades\Validator;

class EkskulController extends Controller
{
    public function create_page(){
        return view('/ekskulpage/ekskulCreate');
    }

    public function create_ekskul(Request $request){
        $this->validate($request,[
            'namaEkskul' => 'required',
            'tglBerdiri' => 'required',
            'logo' => 'required|image|mimes:jpeg,jpg,png,svg',
        ]);

        $logo = $request->file('logo');
        $filename = "logo_".$request->namaEkskul;

        $dir_upload = "uploaded_files"."/"."Ekstrakurikuler/".$request->namaEkskul."logo/";
        $logo->move($dir_upload, $filename);

        $ekskul = Ekstrakurikuler::create([
            'namaEkskul' => $request->namaEkskul,
            'tglBerdiri' => $request->tglBerdiri,
            'logo' => $filename
        ]);

        return Redirect::back();
    }
}
