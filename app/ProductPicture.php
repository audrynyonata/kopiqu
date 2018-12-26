<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPicture extends Model
{
    protected $fillable = [
    	'product_id',
    	'filepath'
    ];

    public function product(){
    	return $this->belongsTo('App\Product');
    }
}
