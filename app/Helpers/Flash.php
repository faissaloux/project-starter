<?php 

namespace App\Helpers;
use Slim\Flash\Messages as FlashTwig;

defined('BASEPATH') OR exit('No direct script access allowed');

class Flash {    
  
    public static function success($message){
         $flash = new FlashTwig();
         return $flash->addMessage('success',$message);
    }
    
    public static function error($message){
        $flash = new FlashTwig();
        return $flash->addMessage('error',$message);
    }
    
  
    
}
    