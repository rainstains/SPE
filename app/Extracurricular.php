<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Extracurricular extends Model
{
    
    protected $fillable = [
        'name','dateEstablished','logo', 'status',
    ];

    public function user(){
        return $this->hasMany('App\User');
    }

    public function achievement(){
        return $this->hasMany('App\Achievement');
    }

    public function activity(){
        return $this->hasMany('App\Activity');
    }

    public function student(){
        return $this->belongsToMany('App\Student')->using('App\Member')->withPivot('status','angkatan');
    }
}
