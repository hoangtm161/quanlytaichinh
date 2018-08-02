<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table='wallets';
    protected $fillable=[
        'id',
        'name',
        'balance',
        'users_id_foreign'
    ];
}
