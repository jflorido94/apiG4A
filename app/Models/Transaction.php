<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // la realiza un comprador
    public function buyer()
    {
        return $this->belongsTo(User::class);
    }

    // tiene un vendedor
    public function seller()
    {
        return $this->belongsTo(User::class);
    }

    // tiene un estado
    // public function state()
    // {
    //     return $this->belongsTo(State::class);
    // }

    // tiene un producto
    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    // tiene una review
    public function review()
    {
        return $this->hasOne(Review::class);
    }


    // recibe varios reportes
    // public function accusations()
    // {
    //     return $this->morphMany(Report::class, 'reportable');
    // }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'amount',
        'product_id',
        'buyer_id' ,
        'seller_id',
    ];

}
