<?php

namespace App\Models;
use illuminate\database\eloquent\model;


class Shipping extends model{

    protected $table = 'shipping';
    
    protected $guarded = ['id', 'created_at', 'updated_at'];
    

    
    public function statueDisplay(){
        
        
        if($this->statue == 'active') {
            echo '<span class="label border-left-success label-striped">مفعل</span>';
        }else{
            
        echo '<span class="label border-left-primary label-striped">غير مفعل</span>';
        }
    }
}
