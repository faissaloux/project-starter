<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\files;


defined('BASEPATH') OR exit('No direct script access allowed');

class CommentsController extends Controller {
    
    
    public $route = [ 'index' => 'comments' , 'create' => 'comments.create'  ];
    public $model = 'Comments';
    public $folder = 'comments';
    
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
    
    
    
    public function store($request,$response,$args){
            $post = validator::cleanify($request->getParams());
            $user_id = isset($_SESSION['auth-user']) ? $_SESSION['auth-user'] : 'quest';
            Comments::create([
                'user_id'   => $user_id,
                'post_id'   => $post['post_id'],
                'author'    => $post['author'],
                'email'     => $post['email'],
                'content'   => $post['body'],
                'approved'  => 1
            ]);
            $this->flashsuccess('تم اضافة التعليق بنجاح');
            return $response->withRedirect($this->router->pathFor('website.post',['id'=>$post['post_id']]));
    }
    
    public function update($request,$response,$args){
        $id = rtrim($args['id'], '/');
        $comment = Comments::find($id);
        $comment->content = $this->helper->clean($request->getParam('content'));
        $comment->save();
        $this->flashsuccess($this->lang['flash']['4']);
        return $response->withHeader('Location', $this->router->urlFor('comments'));
    }
  
   
}

