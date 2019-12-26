<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\Product ;
use \App\Models\ProductCategories;
use \App\Models\Media ;
use \App\Classes\files;

defined('BASEPATH') OR exit('No direct script access allowed');

class ProductsController extends Controller{
    
        
    public $route = [ 'index' => 'products' , 'create' => 'products.create'  ];
    public $model = 'Product';
    public $folder = 'products';
    
    public $messages = [
        'created'           => 'product has been created successfully',
        'deleted'           => 'product has been deleted successfully',
        'updated'           => 'product has been updated successfully',
        'bulkDelete'        => 'all products deleted successfully',
        'cloned'            => 'product has been duplicated successfully',
          'multi.delete'        => 'All products has been deleted successfully',
        'multi.clone'        => 'All products has been duplicated successfully',
    ];
    
    

    
    public function saveData($content,$post,$update){
            $up     = $this->files;
            $helper = $this->helper;
            $path   = $this->dir('products');
            $thumb  = $_FILES['ProductThumbnail'];
                   
            if(!$update){
                $thumbnail = !empty($file['name']) ? $up->up($dir,$file) : " ";
            }
        
            if(isset($post['isAdChanged']) == 'true') {
                $thumbnail = !empty($thumb['name']) ? $up->up($path,$thumb) : ' ';
                $old = $path.$product->thumbnail;if(file_exists($old)) { unlink($old); }
            }
       
            $content->name           = $post['title'];
            $content->description    = $post['description'] || '';
            $content->thumbnail      = !empty($thumb['name']) ? $up->up($path,$thumb) : ' ';
            $content->gallery        = isset($post['gal']) ? $helper->gallery($post['gal']) : '' ;
            $content->price          = $post['price'];
            $content->discount_price = $post['discount_price'];
            $content->categoryID     = $post['category'] || '';;
            $content->videos         = implode('||',$post['videos']);
            $content->slug           = $helper->string_To_Uri($post['slug']);
            $content->save();
    }
    
    
    public function create($request,$response){
          $categories = ProductCategories::all();
          return $this->view->render($response,'admin/products/create.twig',compact('categories')); 
    }
    


    public function edit($request,$response,$args){
        $id = rtrim($args['id'], '/');
        $product = Product::find($id);
        $media = Media::latest()->get();
        $categories = ProductCategories::all();
        return $this->view->render($response,'admin/products/edit.twig',compact('product','categories','media'));
    }


  
}
 