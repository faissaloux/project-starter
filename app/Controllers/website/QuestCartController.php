<?php

namespace App\Controllers\website;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Controllers\Controller as Controller;
use \App\Models\Product;
use \App\Models\WishList;
class QuestCartController extends Controller{
    
    
    // add to cart with ajax
    public function ajax1($request,$response,$args) {
        $get = Product::find($_POST['product']);
        $product = array( 
            'id'=> $get->id , 
            'name' => $get->name, 
            'thumbnail' => $get->thumbnail, 
            'price' => $get->discount_price, 
            'q' => 1 
        );
        $_SESSION['CART'][$_POST['product']] = $product;
        $data['product'] = $product;
        $data['count'] = count($_SESSION['CART']);
        echo json_encode($data);
    }
    
    
    // add to ajax with the quantity
    public function ajax2($request,$response,$args) {

    }


    // remove from the cart
    public function ajax3($request,$response,$args) {
         if(isset($_POST['product'])){ unset($_SESSION['CART'][$_POST['product']]); }
    }
    
    // empty the cart 
    public function ajax4($request,$response,$args) {
     return  $_SESSION['CART'] = [];
    }
    
    
    
    
    // add to WishList with ajax
    public function ajax5($request,$response) {
        WishList::firstOrCreate(['productID' => $_POST['product'],'user_id' => $_SESSION['auth-user']]);
    }
    
    
    // Remove From WishList with ajax
    public function ajax6($request,$response) {
        if(isset($_SESSION['auth-user'])) {
            WishList::where(['productID' => $_POST['product'],'user_id' => $_SESSION['auth-user'] ])->delete();
        }
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}