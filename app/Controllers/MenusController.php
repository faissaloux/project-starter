<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\Menus;

defined('BASEPATH') OR exit('No direct script access allowed');

class MenusController extends Controller {
    
    
    public $model = 'Menus';
    public $folder = 'menus';
    
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
    
    public $route = [ 
        'index' => 'menus' , 
        'create' => 'menus.create'  
    ];
    
    
    
    public function index($request,$response) {
        
            $menus = Menus::all();
        
            $pages = $this->db->table('pages')->take(7)->get()->toArray();
            $posts = $this->db->table('posts')->take(7)->get()->toArray();
            if(count($menus)){
                $menu  = $menus->first()->toArray();
            }else {
                $menu = [];
            }
         
            return $this->container->view->render($response,'admin/menus/index.twig',[
                'menus'=>$menus,
                'menu'=>$menu,
                'htmlMenu' => isset($menu['menu']) ? json_decode($menu['menu'], TRUE) : ' ',
                'pages'=>$pages,
                'posts'=>$posts
            ]); 
    }
    
  
    public function create ($request,$response) {
          
        $post   = $request->getParams();
        $helper = $this->helper;
        $name = $helper->clean($post['name']);
        
        if(!empty($name)){
            $menu = Menus::create([ 'name' => $name ]); 
            $this->flashsuccess($this->lang['flash']['16']);
            return $response->withHeader('Location', $this->router->urlFor('menus.edit',['id'=>$menu->id]));
        }
        
        $this->flasherror($this->lang['flash']['17']);
        return $response->withRedirect($this->router->pathFor('menus'));
    }
    
    
    
    public function edit ($request,$response,$args) {
        
        // Get  the id
        $id = rtrim($args['id'], '/');
        $menu = Menus::find($id);
        $menus = Menus::all();
        $pages = $this->db->table('pages')->take(7)->get()->toArray();
        $posts = $this->db->table('posts')->take(7)->get()->toArray();
        
        
        if($request->getMethod() == 'GET'){ 
           return $this->container->view->render($response,'admin/menus/index.twig',[
                'menus'=>$menus,
                'menu'=>$menu,
                'htmlMenu' => json_decode($menu['menu'], TRUE),
                'pages'=>$pages,
                'posts'=>$posts
            ]); 
        }
        
        
        if($request->getMethod() == 'POST'){ 
            
            $menu->name =  $request->getParam('menu_name');
            $decodedmenu = json_decode($request->getParam('menu_json'), TRUE);
            $menu->area = $request->getParam('area');
            
            // change the all the ids of the menu items, when saving , and delete new-1 
            $i = 0;  
            $c = 1000;
            
            for($x=0;$x<count($decodedmenu);$x++):
                  $decodedmenu[$x]['id'] = $i ;
            
   
                  if(isset($decodedmenu[$x]['children'])){
                        for($v=0;$v<count($decodedmenu[$x]['children']);$v++):
                            $decodedmenu[$x]['children'][$v]['id'] = $c;
                            $c++;
                         endfor;
                    }
                $i++; 
            endfor;

            $menu->menu = json_encode( $decodedmenu , JSON_UNESCAPED_UNICODE );
             
             // saving the menu
             $menu->save();  
            
            $this->flashsuccess($this->lang['flash']['18']);
            return $response->withRedirect($this->router->pathFor('menus',['id'=>$id]));

        }
    }   
    
    
    
}

