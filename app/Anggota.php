<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Pivot
{
    protected $table = 'anggota';
    
    protected $fillable = [
        'status','angkatan','siswa_id', 'ekskul_id',
    ];

    public function ekstrakurikuler(){
        return $this->belongsTo('App\Ekstrakurikuler');
    }

    public function siswa(){
        return $this->belongsTo('App\Siswa');
    }
}
