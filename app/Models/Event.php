<?php

namespace App\Models;
use illuminate\database\eloquent\model;

class Event extends model{


    
    protected $table = 'events';
    
    protected $guarded = ['id', 'created_at', 'updated_at'];
  

//    // Get Post User
//    public function writer(){
//        return $this->belongsTo('\App\Models\User','author');
//    }
    
  
    
    
    
}