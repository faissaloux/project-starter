<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Capsule\Manager as Capsule;

defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends Controller{
   
  
    public function home($request,$response) {
     
        $count = Capsule::select("SELECT 
         (SELECT COUNT(*) FROM products) as products, 
         (SELECT COUNT(*) FROM users) as users, 
         (SELECT COUNT(*) FROM emails) as emails,
         (SELECT COUNT(*) FROM posts) as posts, 
         (SELECT COUNT(*) FROM orders) as orders, 
         (SELECT COUNT(*) FROM pages) as pages
        ");

       return $this->container->view->render($response,'admin/statiquePages/home.twig',['count'=>$count[0]]);
    }
    
    public function page404($request,$response){
        return $this->view->render($response,'admin/errors/404.twig');
    }
   
    public function FileManager($request,$response){
        return $this->view->render($response,'FileManager.php');
    }
   
     
}

