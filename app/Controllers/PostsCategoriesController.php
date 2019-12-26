<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\PostsCategories;

defined('BASEPATH') OR exit('No direct script access allowed');

class PostsCategoriesController extends Controller {

    
        
    public $route = [ 'index' => 'coupons' , 'create' => 'coupons.create'  ];
    public $model = 'user';
    public $folder = 'coupons';
    
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
 
    
        if($request->getMethod() != 'POST'){

                $searchview     = false;
                $count          = PostsCategories::count();   
                $page           = ($request->getParam('page', 0) > 0) ? $request->getParam('page') : 1;
                $limit          = 10; 
                $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));    // the number of the pages
                $skip           = ($page - 1) * $limit;
                $categories     = PostsCategories::skip($skip)->take($limit)->orderBy('created_at', 'desc')->get();
                    
//    PostsCategories::leftJoin('posts', 'posts.categoryID', '=', 'postscategories.id')
//  ->selectRaw('postscategories.*, count(posts.categoryID) as postsCount')->skip($skip)->take($limit)->orderBy('created_at', 'desc')->get();

                return $this->view->render($response, 'admin/posts/categories/index.twig', [
                    'pagination'    => [
                        'needed'        => $count > $limit,
                        'count'         => $count,
                        'page'          => $page,
                        'lastpage'      => $lastpage,
                        'limit'         => $limit,
                        'prev'          => $page-1,
                        'next'          => $page+1,
                        'start'          => max(1, $page- 4),
                        'end'          => min($page + 4, $lastpage),
                    ],
                  'categories'=> $categories ,
                ]);
                           
     
        }
        
        
        if($request->getMethod() == 'POST'){

            // get the form data
            $post   = $request->getParams();
            $helper = $this->helper;

            // clean the form data & set the error route
            $name   = $helper->clean($post['name']);
            $slug   = $helper->string_To_Uri($helper->clean(strtolower($post['slug'])));
            $route  = $response->withStatus(302)->withHeader('Location', $this->router->urlFor('posts.categories'));;

            // check if the name or the slug are not empty
            if(empty($name) or empty($slug)) { $this->flasherror($this->lang['flash']['49']);  return $route; }

            // check if the slug is alphanumeric
            if($helper->is_slug($slug)){  $this->flasherror($this->lang['flash']['50']); return $route; }

            // check if the name of the slug is used already
            $unique = PostsCategories::where('slug','=',$slug)->orWhere('name','=',$name)->first();

            // check if the name is unique
            if($unique->name == $name) { $this->flasherror($this->lang['flash']['51']);return $route;}

            // check if the slug is unique
            if($unique->slug == $slug) { $this->flasherror($this->lang['flash']['52']); return $route;}

            // create the category
            PostsCategories::create([ 'name' => $name, 'slug' => $slug ]);

            // success
            $this->flashsuccess($this->lang['flash']['53']);
            return $route;
        }
        
        
    }  
 
   public function delete($request,$response,$args) {
        // get the category id
        $id = rtrim($args['id'], '/');
       
        // get the category
        $categorie = PostsCategories::find($id);
       
        // delete if found
        if($categorie){
            $categorie->delete();
            $this->flashsuccess($this->lang['flash']['54']);
        }
        return $response->withRedirect($this->router->pathFor('posts.categories'));
    }
    
   public function edit($request,$response,$args) {
        
        // get the category id
        $id = rtrim($args['id'], '/');
        
        // get the category
        $categorie = PostsCategories::find($id);
       
        if($request->getMethod() == 'GET'){
            if($categorie){
                return $this->view->render($response, 'admin/posts/categories/edit.twig',['categorie'=>$categorie]);
            }
            return $response->withRedirect($this->router->pathFor('posts.categories'));
        }
    
       
        if($request->getMethod() == 'POST'){
            
             // get the form data
            $post   = $request->getParams();
            $helper = $this->helper;
            $route  = $response->withRedirect($this->router->pathFor('posts.categories.edit', ['id'=> $id ,'categorie' => $categorie]));

            // clean the form data & set the error route
            $name   =  $helper->clean($post['name']);
            $slug   = $helper->string_To_Uri($helper->clean(strtolower($post['slug'])));
            
            // check if the name of the slug is used already
            $unique = PostsCategories::where('slug','=',$slug)->orWhere('name','=',$name)->first();
            
            // check if the name or the slug are not empty
            if(empty($name) or empty($slug)) { $this->flasherror($this->lang['flash']['55']); return $route;}
            
            // check if the slug is alphanumeric
            if($helper->is_slug($slug)){ $this->flasherror($this->lang['flash']['56']); return $route;}
            
            // edit and save 
            $categorie->name = $name;
            $categorie->slug = $slug;
            $categorie->save();
            
            // success
            $this->flashsuccess($this->lang['flash']['57']);
            return $response->withRedirect($this->router->pathFor('posts.categories'));
        }

        
    }
    

}