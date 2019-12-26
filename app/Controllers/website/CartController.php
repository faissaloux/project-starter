<?php

namespace App\Controllers\website;

use App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\files;
use \App\Models\Emails;
use \App\Models\Product;
use \App\Models\Cart;


class CartController extends \App\Controllers\Controller{
    
    
    public function index($request,$response) {
       return $this->container->view->render($response,'website/cart.twig');
    }
 

}