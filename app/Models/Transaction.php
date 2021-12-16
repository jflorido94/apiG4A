<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // la realiza un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // tiene un estado
    public function state()
    {
        return $this->belong(State::class);
    }

    // tiene un producto
    public function product()
    {
        return $this->hasOne(Product::class);
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
