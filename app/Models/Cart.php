<?php

namespace App\Models;
use illuminate\database\eloquent\model;


class Cart extends model{

    protected $table = 'productscart';
    
    protected $guarded = ['id', 'created_at', 'updated_at'];
    
    public function product() {
        return $this->belongsTo('\App\Models\Product','productID');
    }
    
    
}