<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'name','desc','date','confirm', 'photo', 'period', 'extracurricular_id',
    ];

    public function extracurricular(){
        return $this->belongsTo('App\Extracurricular');
    }
}
