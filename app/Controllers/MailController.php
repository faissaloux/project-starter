<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\Emails;

defined('BASEPATH') OR exit('No direct script access allowed');

class MailController extends Controller {
    
    
        
    public $route = [ 'index' => 'coupons' , 'create' => 'coupons.create'  ];
    public $model = 'Emails';
    public $folder = 'mail';
    
    public $messages = [
        'created'           => 'coupon code has been created successfully',
        'deleted'           => 'copoun code has been deleted successfully',
        'updated'           => 'copoun code has been updated successfully',
        'bulkDelete'        => 'copouns has been deleted successfully',  
    ];
    
    public function edit($request,$response,$args) { 
            $email = Emails::find($args['id']);
            $email->seen = 1;
            $email->save();
            return $this->container->view->render($response,'admin/mail/show.twig',['email'=>$email]);
    } 

    
    
}

