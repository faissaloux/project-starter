<?php 

namespace App\Helpers;

defined('BASEPATH') OR exit('No direct script access allowed');

class Text {
    
  
     
    public static function random($length = 20) {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }
     
    
}