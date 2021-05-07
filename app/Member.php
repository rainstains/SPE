<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Member extends Pivot
{
    protected $table = 'extracurricular_student';

    public $timestamps = false;
    
    protected $fillable = [
        'status','angkatan','student_id', 'extracurricular_id',
    ];

    public function extracurricular(){
        return $this->belongsTo('App\Extracurricular');
    }

    public function student(){
        return $this->belongsTo('App\Student');
    }
}
