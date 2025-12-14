<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    public function video(){
        return $this->belongsTo(Video::class);
    }
}
