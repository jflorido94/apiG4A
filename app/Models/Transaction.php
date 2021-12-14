<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // tiene un estado
    public function state()
    {
        return $this->hasOne(State::class);
    }

    // tiene una review
    public function review()
    {
        return $this->hasOne(Review::class);
    }


    // recibe varios reportes
    public function accusations()
    {
        return $this->morphMany(Report::class, 'reportable');
    }
}
