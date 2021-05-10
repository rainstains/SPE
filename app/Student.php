<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'nis', 'name','class',
    ];

    public function extracurricular(){
        return $this->belongsToMany('App\Extracurricular')->using('App\Member')->with('status','angkatan');
    }
}
