<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\Faqs;
use \App\Models\FaqsCategories;
use \App\Classes\files;

defined('BASEPATH') OR exit('No direct script access allowed');

class FaqsController  extends Controller {
    
    
        
    
    public $route = [ 'index' => 'faqs' , 'create' => 'faqs.create'  ];
    public $model = 'Faqs';
    public $folder = 'faq';
    
    public $messages = [
        'created'           => 'coupon code has been created successfully',
        'deleted'           => 'copoun code has been deleted successfully',
        'updated'           => 'copoun code has been updated successfully',
        'bulkDelete'        => 'copouns has been deleted successfully',
        'cloned'            => 'copoun code has been duplicated successfully',   
    ];
    
    
    
     
    
       public function front($request,$response) {
           
             $posts = Faqs::leftJoin('faqscategories', 'faqscategories.id', '=', 'faqs.category')->select('faqscategories.name', 'faqs.*')
        ->get();
           

          
           
    $faqs = array();
    foreach ($posts->toArray() as $element) {
        $faqs[$element['name']][] = $element;
    }
           
           
           
           
           
           
           
           
           
           
           
           
           return $this->view->render($response, 'website/faqs.twig', compact('faqs'));
        }
    
    
    
    
    
    
    
    public function saveData($content,$post,$update){
        $content->question = $post['question'];
        $content->answer = $post['answer'];
        $content->category   = $post['postCategory'];
        $content->save();
    }
    
    
  
    public function edit($request,$response,$args) {
        $categories = FaqsCategories::all();
        $id = rtrim($args['id'], '/');
        $faq = Faqs::find($id);
        $this->container->view->render($response,'admin/faq/edit.twig',['post'=>$faq,'categories'=>$categories]);
    }
    
    
    

   
    

    
    
    /*
    *       Faqs Categoris
    */
    public function categories($request,$response){
        $searchview     = false;
        $count          = FaqsCategories::count();   
        $page           = ($request->getParam('page', 0) > 0) ? $request->getParam('page') : 1;
        $limit          = 10; 
        $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));    // the number of the pages
        $skip           = ($page - 1) * $limit;
        $categories     = FaqsCategories::skip($skip)->take($limit)->orderBy('created_at', 'desc')->get();

        return $this->view->render($response, 'admin/faq/categories/index.twig', [
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
    
    
    
    public function categories_edit($request,$response,$args){
        
        // get the id
        $id = rtrim($args['id'], '/');
        
        // get the Faq categorie
        $categorie = FaqsCategories::find($id);
        
        if($request->getMethod() == 'GET'){
            if($categorie) {
                return $this->view->render($response, 'admin/faq/categories/edit.twig',['categorie'=>$categorie]);
            }
            return $response->withRedirect($this->router->pathFor('faqs.categories'));
        }
    
        if($request->getMethod() == 'POST'){
            
            $post = validator::cleanify($request->getParams());

            // check if the name or the slug are not empty
            if(empty($post['name'])) {
                $this->flasherror($this->lang['flash']['10']);
                return $response->withRedirect($this->router->pathFor('faqs.cat.edit',compact('id','categorie')));
            }
            
            // update the info in the database
            $categorie->name = $post['name'];
            $categorie->save();
            
            // success &  redirect
            $this->flashsuccess($this->lang['flash']['11']);
            return $response->withRedirect($this->router->pathFor('faqs.categories'));
            
        }
    }
    
    
    // Faqs Categorie Delete
    public function categories_delete($request,$response,$args){
        
        // get the id
        $id = rtrim($args['id'], '/');
        
        // get the categorie
        $categorie = FaqsCategories::find($id);
        
        // if the categorie exist , delete it
        if($categorie) {$categorie->delete(); $this->flashsuccess($this->lang['flash']['12']); }
        return $response->withRedirect($this->router->pathFor('faqs.categories'));

    }
    
    
    // Faqs categorie create
    public function categories_create($request,$response){
        
            // get the category name & clean it
            $name = $this->helper->clean($request->getParam('name'));
            
            // check if it is unique
            $unique = FaqsCategories::where('name','=',$name)->first();
            
            // route to redirect
            $route =  $response->withRedirect($this->router->pathFor('faqs.categories'));
        
            // check if the name or the slug are not empty
            if(empty($name)) { $this->flashflasherror($this->lang['flash']['13']);return $route;   }
           
            // check if the name is unique
            if($unique->name == $name) { $this->flasherror($this->lang['flash']['14']); return $route;}
            
            // create the category
            FaqsCategories::create([ 'name' => $name]);
            
            // success
            $this->flashsuccess($this->lang['flash']['15']); return $route;
    }


}