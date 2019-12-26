<?php

namespace App\Controllers\website;

use App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\User;


class PasswordController extends \App\Controllers\Controller{
    
    public function index($request,$response) {
          return $this->view->render($response, 'website/password.twig');
    }

    public function store ($request,$response,$args){
       
       
       $post = validator::cleanify($request->getParams());
       $route = $response->withHeader('Location', $this->router->urlFor('website.password'));
       $id = $post['user_id']; 
       $user = User::where('id','=',$id)->first();    
       unset($post['user_id']); 
 
        // check if the password is correct
        if(!password_verify($post['password'],$user->password)) {
          $this->flasherror('current password is wrong, please try again !');
          return $route;
        }

        // check if the new passwords are not empty
        if(empty($post['newpassword']) or empty($post['confirmPassword'])){
          $this->flasherror('please insert the passwords');
          return $route;
        }

        // check if the new password is correct
        if($post['newpassword'] != $post['confirmPassword']){
          $this->flasherror('the new password dosent match');
          return $route;
        }

        // hash the new password & and add it to database & save
        $password = password_hash($post['newpassword'],PASSWORD_DEFAULT);    
        $user->password = $password;
        $user->save();

        // success & redirect
        $this->flashsuccess('password updated successflly');
        return $route;

    } 

    

    
    
    
}















