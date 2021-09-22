<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statuse extends Model
{
    public function statuseHasTasks()
    {
        return $this->hasMany('App\Models\Task', 'statuse_id', 'id');
    }
}
