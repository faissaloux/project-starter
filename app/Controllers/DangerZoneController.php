<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\files;
use JasonGrimes\Paginator;

defined('BASEPATH') OR exit('No direct script access allowed');

class DangerZoneController extends Controller {
    
    
    
    

    public $route = [ 'index' => 'dangerzone.index'  ];
    
    public $messages = [
        'cleand'           => 'تم تفريغ المحتوى بنجاح',    
    ];
    
            
    // index Page, Get all ads
    public function index($request,$response) {
        return $this->view->render($response, 'admin/statiquePages/dangerzone.twig');    
    }
    
   
    
    public function clean($request,$response,$args){
        $this->model = rtrim($args['model'], '/');
        $modelClass = $this->init();
        if($this->model == 'User'){
             $modelClass::where('statue', '!=', 'supper')->delete();
        }else{
            $modelClass::truncate();
        }
        $this->flashsuccess($this->messages['cleand']);  
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor($this->route['index']));
    }

}

