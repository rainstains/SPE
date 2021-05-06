<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Extracurricular extends Model
{
    
    protected $fillable = [
        'name','dateEstablished','logo', 'status',
    ];

    public function users(){
        return $this->hasMany('App\User');
    }

    public function student(){
        return $this->belongsToMany('App\Student')->using('App\Member')->withPivot('status','angkatan');
    }
}
