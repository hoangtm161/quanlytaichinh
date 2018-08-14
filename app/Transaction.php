<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table='transactions';
    protected $fillable=[
        'amount',
        'description',
        'type',
        'transaction_at',
        'categories_id_foreign',
        'wallets_id_foreign'
    ];

    public function wallets()
    {
        return $this->belongsTo('App\Wallet','wallets_id_foreign','id');
    }

    public function categories()
    {
        return $this->belongsTo('App\Category','categories_id_foreign', 'id');
    }
}
