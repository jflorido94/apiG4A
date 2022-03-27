<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // tiene un wallet
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    // // tiene varios productos
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // // hace varias compras
    public function sales()
    {
        return $this->hasMany(Transaction::class,'seller_id');
    }

    // // hace varias compras
    public function shoppings()
    {
        return $this->hasMany(Transaction::class,'buyer_id');
    }

    // hace varias reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // tiene votos como vendedor
    public function votes()
    {
        return $this->hasManyThrough(Review::class, Transaction::class, 'seller_id');
    }

    // // hace varios reports
    // public function reports()
    // {
    //     return $this->hasMany(Report::class);
    // }

    // // recibe varios reportes
    // public function accusations()
    // {
    //     return $this->morphMany(Report::class, 'reportable');
    // }

    // // pertenece a varios chats
    // public function chats()
    // {
    //     return $this->belongsToMany(Chat::class);
    // }

    // // envia varios mensajes
    // public function messages()
    // {
    //     return $this->hasMany(Message::class);
    // }

    // public function myReviews(){
    //     return Review::where(Review::transaction());
    // }



    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nick',
        'name',
        'surnames',
        'dni',
        'avatar',
        'email',
        'password',
        'erased',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'is_admin',
        'is_mod',
        'erased',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
