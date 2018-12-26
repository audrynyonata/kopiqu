<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
    	'user_id',
    	'status',
    	'address',
    	'sum_price',
    	'sum_weight',
    	'shipping_fee',
    	'unique_id',
    	'amount'
    ];

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function order_products(){
    	return $this->hasMany('App\OrderProduct');
    }
}
