<?php

namespace App\Controllers\website;

use App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\Page;
use \App\Models\Ads;
use \App\Models\Order;

use \App\Controllers\Controller as controller;


class OrdersController extends Controller{

    public function index($request,$response) {
      
       $orders = Order::where('user_id',$_SESSION['auth-user'])->get();
      
       return $this->container->view->render($response,'website/orders.twig',compact('orders'));
    }

    public function detail($request,$response,$args) {
       $id = rtrim($args['id'], '/');
       $order = Order::find($id);
       return $this->container->view->render($response,'website/order_view.twig',compact('order'));
    }


}
