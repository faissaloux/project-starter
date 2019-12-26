<?php




namespace App\Models;
use illuminate\database\eloquent\model;

use \App\Models\ProductCategories;


class Product extends model{


    
    protected $table = 'products';
    
    protected $guarded = ['id', 'created_at', 'updated_at'];
    
 
    public function ThumbnailsImages(){
        $gallers = explode('//', $this->gallery);
        
        $gallery['1'] = $gallers[0];
        $gallery['2'] = $gallers[1];
        
        return $gallery;
        
    }

    
    public function discounte(){
        if(is_numeric($this->price) and is_numeric($this->discount_price)){
            return '-'.ceil((($this->price - $this->discount_price)*100) /$this->price).'%' ;
        }
        return '';
    }
    
    
    // get the videos array
    public function videos(){
         return !empty($this->videos) ? explode('||', $this->videos) : false ;
    }
    
    // get the gallery array 
    public function gallery(){
         return !empty($this->gallery) ? explode('//', $this->gallery) : false ;
    } 
    
 
    
    // Get Post User
    public function categorie(){
        return $this->belongsTo('\App\Models\ProductCategories','categoryID');
    }
    
    

}