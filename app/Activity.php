<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'name','date','confirm', 'photo', 'extracurricular_id',
    ];

    public function extracurricular(){
        return $this->belongsTo('App\Extracurricular');
    }
}
