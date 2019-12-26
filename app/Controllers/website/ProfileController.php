<?php

namespace App\Controllers\website;

use App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\files;
use \App\Models\Product;
use \App\Models\User;
use \App\Models\ProductCategories;

class ProfileController extends \App\Controllers\Controller{
    
    
      
    public function account($request,$response) {
        
        
        
        return $this->container->view->render($response,'website/account.twig',['user'=> User::find($_SESSION['auth-user']) ]);
    }
    public function store($request,$response,$args) {


       
       $post = validator::cleanify($request->getParams());


       $id = $post['user_id'];
        
       $user = User::where('id','=',$id)->first();    
       
       unset($post['user_id']); 

        
       foreach($post as $key => $value ) {
           $user->$key = $value;
       }

       $user->save();
         
       $this->flashsuccess('profile updated successfly');
       return $response->withHeader('Location', $this->router->urlFor('website.profile'));
       
    } 
    
    
}
