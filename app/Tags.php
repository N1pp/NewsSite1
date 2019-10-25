<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    public function news()
    {
        return $this->belongsToMany('App\News');
    }
}
