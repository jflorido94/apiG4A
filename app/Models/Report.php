<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    // tiene una razon
    public function banReason()
    {
        return $this->hasOne(BanReason::class);
    }

    // es sobre un usuario, producto o transaccion
    public function reportable()
    {
        return $this->morphTo();
    }

    // escrito por un usuario
    public function user(){
        return $this->belongsTo(User::class);
    }
}
