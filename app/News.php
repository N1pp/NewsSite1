<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class News extends Model
{
    protected $fillable = ['rate', 'content', 'title', 'rate', 'comments'];

    public function tags(): ?BelongsToMany
    {
        return $this->belongsToMany(Tags::class);
    }

    public function images(): ?HasMany
    {
        return $this->hasMany(Image::class);
    }
}
