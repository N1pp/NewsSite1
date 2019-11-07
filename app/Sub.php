<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sub extends Model
{
    protected $fillable = ['user_id', 'author_id'];
}
