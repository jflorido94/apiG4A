<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    // es escrita por un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // es sobre una compra
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'comment',
        'stars',
        'user_id',
        'transaction_id',
    ];
}
