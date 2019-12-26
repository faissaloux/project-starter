<?php

namespace App\Models;
use illuminate\database\eloquent\model;

class FaqsCategories extends model{
    
    protected $table = 'faqscategories';
    
    protected $guarded = ['id', 'created_at', 'updated_at'];  
    
}