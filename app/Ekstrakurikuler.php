<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ekstrakurikuler extends Model
{
    protected $table = 'ekstrakurikuler';
    
    protected $fillable = [
        'namaEkskul','tglBerdiri','logo',
    ];

    public function users(){
        return $this->hasMany('App\User');
    }

    public function siswa(){
        return $this->belongsToMany('App\Siswa')->using('App\Anggota')->withPivot('status','angkatan');
    }

}
