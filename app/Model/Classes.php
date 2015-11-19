<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $table    = 'classes';
    protected $fillable = ['id', 'scholastic' , 'classname', 'homeroom_teacher'];
    public $timestamps  = false;

    public function students()
    {
        return $this->hasMany('App\Model\StudentClass' , 'class_id', 'id');
    }

    public function teacher()
    {
        return $this->belongsTo('App\Model\Teacher' , 'homeroom_teacher', 'id');   
    }

}
