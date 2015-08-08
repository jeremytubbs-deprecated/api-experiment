<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SluggerTrait;

class Category extends Model
{
    use SluggerTrait;

    protected $fillable = ['name', 'slug', 'description'];

    public function contents()
    {
        return $this->hasMany('App\Models\Content');
    }

}
