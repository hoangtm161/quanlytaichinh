<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'type',
        'categories_parent_id',
        'users_id_foreign'
    ];

    public function transactions()
    {
        $this->hasMany('App\Transaction', 'categories_id_foreign', 'id');
    }
}
