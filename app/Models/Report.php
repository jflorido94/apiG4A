<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;


    public function banReason()
    {
        return $this->hasOne(BanReason::class);
    }

    public function reportable()
    {
        return $this->morphTo();
    }
}
