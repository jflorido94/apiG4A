<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    public function condition()
    {
        return $this->hasOne(Condition::class);
    }

    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }
}
