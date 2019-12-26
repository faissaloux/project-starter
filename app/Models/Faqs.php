<?php

namespace App\Models;
use illuminate\database\eloquent\model;

class Faqs extends model{
    
    protected $table = 'faqs';
    
    protected $guarded = ['id', 'created_at', 'updated_at'];  
    
    
   
    public function categorie(){
        return $this->belongsTo('\App\Models\FaqsCategories','category');
    }
    
    
}