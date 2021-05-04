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

}
