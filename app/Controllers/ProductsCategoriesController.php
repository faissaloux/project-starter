<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\files;
use \App\Models\Product;
use \App\Models\ProductCategories;


defined('BASEPATH') OR exit('No direct script access allowed');

class ProductsCategoriesController extends Controller {
    
    
        
    public $route = [ 'index' => 'products.categories' , 'create' => 'products.categories'  ];
    public $model = 'ProductCategories';
    public $folder = 'products/categories';
    
    public $messages = [
        'created'           => 'coupon code has been created successfully',
        'deleted'           => 'copoun code has been deleted successfully',
        'updated'           => 'copoun code has been updated successfully',
        'bulkDelete'        => 'copouns has been deleted successfully',
        'cloned'            => 'copoun code has been duplicated successfully',
        'NotValid'          => 'coupon code is not valid or expired',
        'Expired'           => 'your copoun has been created sesc',
        'applied'           => 'copoun code has been applied successfully',    
    ];
    
    
    
    public function index($request,$response){
 
        if($request->getMethod() == 'POST'){
        
            // get the form data
            $post   = $request->getParams();
            $helper = $this->helper;

            // clean the form data & set the error route
            $name   = $helper->clean($post['name']);
            $slug   = $helper->string_To_Uri($helper->clean(strtolower($post['slug'])));
            $route = $response->withRedirect($this->router->pathFor('products.categories'));
            
            // check if the slug or the name is already exist
            $unique = ProductCategories::where('slug','=',$slug)->orWhere('name','=',$name)->first();
            
            // check if the name or the slug are not empty.
            
            if(empty($name) or empty($slug)) { $this->flasherror($this->lang['flash']['63']); return $route; }
            
            // check if the slug is alphanumeric
            if($helper->is_slug($slug)){$this->flasherror($this->lang['flash']['64']);return $route; }
            
            // check if the name is unique
            if($unique->name == $name) {$this->flasherror($this->lang['flash']['65']);return $route;}
            
            // check if the slug is unique
            if($unique->slug == $slug) {$this->flasherror($this->lang['flash']['66']); return $route;}

            // create the category
            ProductCategories::create(['name' => $name,'slug' => $slug ]);
            
            // success
            $this->flashsuccess($this->lang['flash']['67']);
            return $route;
            
        }
        
        if($request->getMethod() != 'POST'){

                $searchview     = false;
                $count          = ProductCategories::count();   
                $page           = ($request->getParam('page', 0) > 0) ? $request->getParam('page') : 1;
                $limit          = 10; 
                $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));    // the number of the pages
                $skip           = ($page - 1) * $limit;
                $categories     = ProductCategories::skip($skip)->take($limit)->orderBy('created_at', 'desc')->get();

                return $this->view->render($response, 'admin/products/categories/index.twig', [
                    'pagination'    => [
                        'needed'        => $count > $limit,
                        'count'         => $count,
                        'page'          => $page,
                        'lastpage'      => $lastpage,
                        'limit'         => $limit,
                        'prev'          => $page-1,
                        'next'          => $page+1,
                        'start'          => max(1, $page - 4),
                        'end'          => min($page + 4, $lastpage),
                    ],
                  'categories'=> $categories ,
                ]);
        }
    }  
    
 
   public function delete($request,$response,$args) {
        
        // get the id
        $id = rtrim($args['id'], '/');
       
        // get the categorie & delete
        $categorie = ProductCategories::find($id);
        if($categorie) {
            $categorie->delete();
            $this->flashsuccess($this->lang['flash']['68']);
        }
       
       return $response->withRedirect($this->router->pathFor(''));

    }
    
    
    public function edit($request,$response,$args) {
        
        // get the id
        $id = rtrim($args['id'], '/');
        
        // get the categorie
        $categorie = ProductCategories::find($id);
        
        if($request->getMethod() == 'GET'){
            if($categorie){                
                return $this->view->render($response, 'admin/products/categories/edit.twig',['categorie'=>$categorie]);
            }
        }
    
        if($request->getMethod() == 'POST'){
            
            // get the form data
            $post   = $request->getParams();
            $helper = $this->helper;
            
            // clean the form data & set the error route
            $name   = $helper->clean($post['name']);
            $slug   = $helper->string_To_Uri($helper->clean(strtolower($post['slug'])));
            $route  = $response->withRedirect($this->router->pathFor('products.categories.edit', ['id'=> $id , 'categorie' => $categorie]));
            
            // check if the name of the slug is used already
            $unique = ProductCategories::where('slug','=',$slug)->orWhere('name','=',$name)->first();
            
            // check if the name or the slug are not empty
            if(empty($name) or empty($slug)) { $this->flasherror($this->lang['flash']['69']); return $route; }
           
            // check if the slug is alphanumeric
            if($helper->is_slug($slug)){ $this->flasherror($this->lang['flash']['70']);return $route;}
            
            // edit & save
            $categorie->name = $name;
            $categorie->slug = $slug;
            $categorie->save();
            
            // success
            $this->flashsuccess($this->lang['flash']['71']);
            return $response->withRedirect($this->router->pathFor('products.categories'));
            
        }
        
    }
    
}