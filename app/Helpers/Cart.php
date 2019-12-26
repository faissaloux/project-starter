<?php 

namespace App\Classes;
use \App\Models\Product;

defined('BASEPATH') OR exit('No direct script access allowed');

class Cart {
    
  
    
    
    public static function getproducts(){
        $products = [];
        foreach(self::get_cart() as $product) {
            $pr = Product::find($product['id']);
            if($pr){
                $products[] = ['id'=> $pr->id, 'name'=> $pr->name , 'price' => $pr->discount_price , 'quantity'=>$product['q']];
            }
        }
        return $products;
    }
    
    
    public static function get_cart(){
        $cart = [];
        foreach($_SESSION['CART'] as $product){
            $cart[] = ['id'=>$product['id'],'q'=>$product['q']];
        }  
        return $cart;
    }
    
    public static function getTotalPrice(){
         $total = [];
         foreach(self::getproducts() as $item ) {
            $total[] = $item['price']  * $item['quantity'];
         }
         return array_sum($total);
    }
    
    
    public static function EmptyCart(){
        unset($_SESSION['CART']);
    }
    
    
}
    