<?php

namespace App\Controllers\website;

use App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\Costumer;
use \App\Models\User;
use \App\Models\Shipping;

class ShippingController extends \App\Controllers\Controller{
    
    public function index($request,$response,$args) {
        
        
//        ['shipping'=> Shipping::where('user_id',$_SESSION['auth-user'])->get() ]
         return $this->view->render($response, 'website/addresses.twig'  );
    }

    public function show($request,$response,$args){
//['edit'=> 'true', 'shipping'=> Shipping::find($args['id'])]
         return $this->view->render($response, 'website/shipping.twig'  );
    }

    public function delete($request,$response,$args){
         Shipping::find($args['id'])->delete();
             $this->flashsuccess('Shipping Removed successfully');
       return $response->withHeader('Location', $this->router->urlFor('website.shipping'));
    }


    public function store ($request,$response,$args){
            
       $post = validator::cleanify($request->getParams());
       $route = $response->withHeader('Location', $this->router->urlFor('website.password'));
       $id = $post['user_id']; 
       $user = User::where('id','=',$id)->first();    
     
       $ship = new Shipping();

       $shippping = Shipping::where('user_id',$_SESSION['auth-user'])->first();


       foreach($post as $key => $value ) {
           $ship->$key = $value;
       }
       if(!$shippping) {
	        $ship->my_default= 1;
       }
       $ship->save();
     
       $this->flashsuccess('Shipping added successfly');
       return $response->withHeader('Location', $this->router->urlFor('website.shipping'));


    }
    
    

    public function default($request,$response,$args){
	    $shippping = Shipping::where('user_id',$_SESSION['auth-user'])->where('my_default','1')->first();
	    if($shippping) {
	        $shippping->my_default= 0;
	        $shippping->save();
            }
	$hop = Shipping::find($args['id']);
	$hop->my_default= 1;
	$hop->save();
	
       $this->flashsuccess('Shipping Address has been set as default successfullyssssssss');
       return $response->withHeader('Location', $this->router->urlFor('website.shipping'));
    }








    
    
}
