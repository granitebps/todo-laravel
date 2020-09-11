<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    public function section()
    {
        return $this->belongsTo('App\Section');
    }
}
