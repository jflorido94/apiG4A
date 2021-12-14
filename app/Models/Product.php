<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // es de un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // tiene una condicion
    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    // recibe varios reportes
    public function accusations()
    {
        return $this->morphMany(Report::class, 'reportable');
    }

}
