<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BanReason extends Model
{
    use HasFactory;

    // tiene muchos reportes p
    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
