<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\files;
use JasonGrimes\Paginator;

defined('BASEPATH') OR exit('No direct script access allowed');

class CouponsController extends Controller {
    
    public $folder = 'coupons';
    public $model = 'coupons';
    public $route = [ 'index' => 'coupons' , 'create' => 'coupons.create'  ];
    
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
    
    
    
    /*
    *   Ajax function
    */
    public function apply($request,$response){
        if(isset($_POST['coupon']) && !empty($_POST['coupon'])){
           $helper = $this->helper;
           $code  =  $helper->clean($_POST['coupon']);
           $discount = $this->ExistValid($code);
            if($discount){
               return  $discount->discount;
            }else{
                return false;
            }
        }
        return false;
    }
    
    
    
    public function ExistValid($code){
            $modelClass = $this->init();
            // check if the copon exist
            $coupon = $modelClass::where('code',$code)->first();
  sv($coupon);
       
         
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
        $content->title =  $post['name'] ;
        $content->code =  $post['code'];
        $content->discount_type =  $post['type'];
        $content->discount =  $post['discount'] ;
        $content->maxUsage =  $post['maxUsage'] ;
        $content->logged =  $post['logged'] ;
        $content->shipping =  $post['shipping'] ;
        $content->valid_from =  $post['date_start'] ;
        $content->valid_to =  $post['date_end'] ;
        //$content->userMax =  $post['uses_total'] ;
        $content->statue =  $post['statue'] ;
        $content->description = $post['description'] ;
        $content->save();  
    }




    

      

}

