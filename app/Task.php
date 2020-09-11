<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->diffForHumans();
    }

    public function section()
    {
        return $this->belongsTo('App\Section');
    }
}
