<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tags extends Model
{
    public function news() : BelongsToMany
    {
        return $this->belongsToMany(News::class);
    }
}
