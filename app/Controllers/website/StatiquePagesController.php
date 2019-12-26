<?php

namespace App\Controllers\website;

use App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;



class StatiquePagesController extends \App\Controllers\Controller{
    
    
    

        public function about($request,$response) {
           return $this->container->view->render($response,'website/about-us.twig');
        }
    
    
    
}