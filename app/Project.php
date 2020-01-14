<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name','thumbnail'
    ];
    
    public function getThumbnailAttribute($value)
    {
        return $value??'flower.jpg';
    }

    public function user()
    {
        return $this->belongsTo('App\User');    
    }

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

   
}
