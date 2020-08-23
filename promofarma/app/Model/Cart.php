<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['id', 'cart_id', 'key', 'userID'];

    public $incrementing = false;

    public function items()
    {
        return $this->hasMany('App\Model\CartItem','cart_id');
    }
}
