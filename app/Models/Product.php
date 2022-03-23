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

    // tiene muchas etiquetas
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    // aparece en una transaccion
    public function transaccition()
    {
        return $this->belongsTo(Transaction::class);
    }

    // recibe varios reportes
    public function accusations()
    {
        return $this->morphMany(Report::class, 'reportable');
    }

}
