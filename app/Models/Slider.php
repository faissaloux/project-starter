<?php




namespace App\Models;
use illuminate\database\eloquent\model;



class Slider extends model{


    protected $table = 'slider';
    
    protected $guarded = ['id', 'created_at', 'updated_at'];
    


}