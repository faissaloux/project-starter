<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
namespace App\Middleware;

defined('BASEPATH') OR exit('No direct script access allowed');

class AuthMiddleware extends Middleware {
    
    public function __invoke($request, $response, $next)
    {
        if(!isset($_SESSION['auth'])) {
            return $this->container->view->render($response,'admin/auth/login.twig');
        }else {
        $response = $next($request, $response);
        return $response;
            
        }
    }

}