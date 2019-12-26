<?php

namespace App\Models;
use illuminate\database\eloquent\model;




class Emails extends model{
  
    
    protected $admin_role = 2;
    protected $table = 'emails';
    protected $guarded = ['id', 'created_at', 'updated_at'];
        
    public function snippet(){
        
        $helper = new \App\Classes\Helper();
        
       echo $helper->get_snippet($this->body,15,' [...] ');
    } 
}