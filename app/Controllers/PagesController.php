<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

defined('BASEPATH') OR exit('No direct script access allowed');

class PagesController extends Controller {
    
    
        
    public $route = [ 'index' => 'pages' , 'create' => 'pages.create'  ];
    public $model = 'Page';
    public $folder = 'pages';
    
    public $messages = [
        'created'           => 'Page has been created successfully',
        'deleted'           => 'Page has been deleted successfully',
        'updated'           => 'Page has been updated successfully',
        'cloned'            => 'Page has been duplicated successfully',
        'bulkDelete'        => 'All Pages has been deleted successfully',
        'multi.delete'        => 'All Pages has been deleted successfully',
        'multi.clone'        => 'All Pages has been duplicated successfully',
    ];
    
    
    public function saveData($content,$post,$update){
        
        $up   = $this->files;
        $file = $_FILES['post_thumbnail'];
        $dir  = $this->dir('pages');
        
        if(!$update){
                $thumbnail = !empty($file['name']) ? $up->up($dir,$file) : " ";
        }
        
        if(isset($form['thumbnailChanged']) == 'true') {
                $thumbnail = !empty($file['name']) ? $up->up($dir,$file) : ' ';
                $old = $dir.$post->thumbnail; if(file_exists($old)){unlink($old);}
         }  
        
        $content->title = $post['title'];
        $content->slug = $post['slug'] || ' ';
        $content->content = $post['post_content'];
        $content->thumbnail = $thumbnail;
        $content->author = $_SESSION['auth-admin'];
        $content->categoryID  = $post['postCategory'] || ' ';
        $content->statue = 1 ;
        $content->save();
        
    }
    
   
}