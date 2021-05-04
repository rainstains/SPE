<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    
    protected $fillable = [
        'nama','kelas',
    ];

    public function ekstrakurikuler(){
        return $this->belongsToMany('App\Ekstrakurikuler')->using('App\Anggota')->with('status','angkatan');
    }
}
