<?php

namespace App\Controllers\website;

use App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\files;
use \App\Models\Emails;
use \App\Models\WishList;
use \App\Models\Product;
use \App\Models\Cart;

class WishListController extends \App\Controllers\Controller{
  
    public function index($request,$response) {
       $wishlist = [];
       if(isset($_SESSION['auth-user'])){ $wishlist = WishList::where('user_id',$_SESSION['auth-user'])->get(); }
        
//        sv($wishlist->toArray());
       return $this->container->view->render($response,'website/wish-list.twig',compact('wishlist'));
    }
    

    
    
   // add all the products to wish list
    public function alltocart($request,$response) {
        
        if(isset($_SESSION['auth-user'])) {
            $wishlist = WishList::where('user_id',$_SESSION['auth-user'])->get();
            foreach($wishlist as $item ) {
              $product = array( 
                    'id'=> $item->product->id , 
                    'name' => $item->product->name, 
                    'thumbnail' => $item->product->thumbnail, 
                    'price' => $item->product->discount_price, 
                    'q' => 1 
                );
                
            $_SESSION['CART'][$item->product->id] = $product;    
        }
        $this->flashsuccess('All wishlist products added to cart successfully');
    }
       
    
        return $response->withRedirect($this->router->pathFor('website.cart'));
       
    }
    
    
    // add the product to the wishlist
    public function add($request,$response,$args) {
        
        // get the product id
        $id = rtrim($args['id'], '/');
        
        
        
        // add product to wish list
        WishList::create([ 'user_id' => $_SESSION['auth-user'], 'productID' => $id ]);
        
        // flash success & redirect
        $this->flashsuccess('تم إضافة المنتوج إلى قائمة الأمنيات بنجاح');
        return $response->withRedirect($this->router->pathFor('website.wishlist',['id'=>$id]));
    }
    
    
    // delete the product from wishlist
    public function delete($request,$response,$args) {
        $id = rtrim($args['id'], '/');
        $wish = WishList::find($id);
        if($wish){
            $wish->delete();
            $this->flashsuccess('تم ازالة المنتوج من قائمة الأمنيات بنجاح');
        }
        return $response->withRedirect($this->router->pathFor('website.product',['id'=>$id]));
    }
   
    
}

