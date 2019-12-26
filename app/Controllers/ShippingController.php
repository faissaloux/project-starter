<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\files;
use JasonGrimes\Paginator;


defined('BASEPATH') OR exit('No direct script access allowed');

class ShippingController extends Controller {
    

    public $model = 'Shipping';
    public $route = [ 'index' => 'shipping' , 'create' => 'shipping.create'  ];
    public $folder = 'shipping';
    
    
    public $messages = [
        'created'           => 'coupon code has been created successfully',
        'deleted'           => 'copoun code has been deleted successfully',
        'updated'           => 'copoun code has been updated successfully',
        'bulkDelete'        => 'copouns has been deleted successfully',
        'cloned'            => 'copoun code has been duplicated successfully',
        'NotValid'          => 'coupon code is not valid or expired',
        'Expired'           => 'your copoun has been created sesc',
        'applied'           => 'copoun code has been applied successfully',    
    ];
    
    
    
    
    public function ExistValid($code){

            // check if the copon exist
            $coupon = Coupon::whereCode($code)->first();

            if($coupon) {

                // set the time of now
                $now = Carbon\Carbon::now(); 

                // check if the code statue is enabled
                if  ( ! $copon->statue == 0 ) { return false;  }

                // check statue if the time is not passed
                if  ( ! $copon->valid_from <= $now AND $copon->valid_to >= $now ) { return false;  }

                return $coupon;
            }

            return false ;

        }

    
    

    public function saveData($content,$fields){
        $post = validator::cleanify($fields);
        $content->name =  $post['name'] ;
        $content->delivery_days =  $post['delivery_days'];
        $content->statue =  $post['statue'];
        $content->cost =  $post['cost'] ;
        $content->save();  
    }


}

