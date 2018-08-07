<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table='wallets';
    protected $fillable=[
        'name',
        'balance',
        'users_id_foreign'
    ];

    public function users()
    {
        return $this->belongsTo('App\User','users_id_foreign','id');
    }

    public function transfers()
    {
        return $this->hasMany('App\Transfer','wallets_send_id','id');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction','wallets_id_foreign','id');
    }
}
