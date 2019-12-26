<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\Post;
use \App\Models\PostsCategories;
use \App\Classes\files;

defined('BASEPATH') OR exit('No direct script access allowed');

class PostsController extends Controller {
        
    public $model    = 'Post';
    public $folder   = 'posts';
    
    public $route    = [ 
        'index' =>  'posts' , 
        'create' => 'posts.create' 
    ];
    
    public $messages = [
        'created'           => 'post has been created successfully',
        'deleted'           => 'post has been deleted successfully',
        'updated'           => 'post has been updated successfully',
        'bulkDelete'        => 'All posts has been deleted successfully',
        'cloned'            => 'post code has been duplicated successfully',
        'multi.delete'      => 'All posts has been deleted successfully',
        'multi.clone'       => 'All posts has been duplicated successfully',
    ];
    
    
    public function saveData($content,$post,$update){
        
        $dir      = $this->dir('posts');
        $file = $_FILES['post_thumbnail']; 
        if(!$update){
                $thumbnail = !empty($file['name']) ? $up->up($dir,$file) : " ";
        }
        
        if(isset($form['thumbnailChanged']) == 'true') {
            $thumbnail = !empty($file['name']) ? $up->up($dir,$file) : ' ';
            $old = $dir.$post->thumbnail; if(file_exists($old)){unlink($old);}
        }  
        
        $content->title = $post['title'] ;
        $content->content  = $post['post_content'];
        $content->thumbnail = $thumbnail;
        $content->author = $_SESSION['auth-admin'];
        $content->statue = '1';
        $content->type = 'post';
        $content->categoryID = $post['postCategory'];
        $content->save();
        
        // share on twitter
        if(!$update){
                $this->AutoShareTwitter();
        }
 
        
        
        
        
    }

    
}

