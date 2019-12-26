<?php

namespace App\Models;
use illuminate\database\eloquent\model;

class Ads extends model{


    private $lang;

    public function __construct(){
        $this->lang = $_SESSION['l'];
    }
    
    
    protected $table = 'ads';
    
    protected $guarded = ['id', 'created_at', 'updated_at'];
    
    
    
    public function displayStatue(){
        
        if($this->statue == 0 ) {
        echo '<span class="label border-left-danger label-striped">'.$this->lang['panelang']['9'].'</span>';
        } else{
            
        echo '<span class="label border-left-success label-striped">'.$this->lang['panelang']['4'].'</span>';
        }
    }
    
    
    
}