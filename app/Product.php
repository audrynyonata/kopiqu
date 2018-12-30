<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
    	'name',
    	'description',
    	'stock',
    	'price',
    	'weight'
    ];

    public function category_products(){
    	return $this->hasMany('App\CategoryProduct');
    }

    public function product_pictures(){
    	return $this->hasMany('App\ProductPicture');
    }

    public function carts(){
        return $this->hasMany('App\Cart');
    }
}
