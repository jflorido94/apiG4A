<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;




    public function state()
    {
        return $this->hasOne(State::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }


    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }
}
