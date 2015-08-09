<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SluggerTrait;

class Content extends Model
{
    use SluggerTrait;

    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at', 'published_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\Type');
    }

    // public function getPublishedAttribute()
    // {
    //     return $this->published_at->diffForHumans();
    // }

    //  public function getPublishedAttribute() {
    //     if($this->status = 1) return 'true';
    //     return 'false';
    // }
}
