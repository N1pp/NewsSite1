<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = ['user_id','rate','content','title','rate','comments'];
    public function tags()
    {
        return $this->belongsToMany('App\Tags');
    }
    public function images()
    {
        return $this->hasMany('App\Image');
    }
}
