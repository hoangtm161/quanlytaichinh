<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $table='transfers';
    protected $fillable=[
        'description',
        'amount',
        'wallets_send_id_foreign',
        'wallets_receive_id_foreign'
    ];

    public function send_wallets()
    {
        return $this->belongsTo('App\Wallet','wallets_send_id_foreign','id');
    }

    public function receive_wallets()
    {
        return $this->belongsTo('App\Wallet','wallets_receive_id_foreign','id');
    }
}
