<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\files;
use JasonGrimes\Paginator;


defined('BASEPATH') OR exit('No direct script access allowed');

class PaymentMethodsController extends Controller {
    

    public $model ;
    public $folder = 'paymentMethods';
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
    
    
    public function savePayment($methodName,$post){
         $this->init('Options')::update_option($methodName,$this->helper->cleanify($post));
    }
    
    
    public function paypal($request,$response) {
        return $this->view->render($response, 'admin/'.$this->folder.'/paypal.twig'); 
    }
    public function stripe($request,$response) {
        return $this->view->render($response, 'admin/'.$this->folder.'/stripe.twig'); 
    }
    public function paypalStore($request,$response) {
        $this->savePayment('Paypal',$request);
        return $this->view->render($response, 'admin/'.$this->folder.'/index.twig'); 
    }
    public function stripeStore($request,$response) {
        return $this->view->render($response, 'admin/'.$this->folder.'/index.twig'); 
    }
}

