<?php

namespace App\Controllers\website;

use App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Classes\files;
use \App\Models\Emails;
use \App\Models\Post;
use \App\Models\PostsCategories;
use \App\Models\Comments;


class BlogController extends \App\Controllers\Controller{
    
    public function index($request,$response) {
                $searchview     = false;
                $count          = Post::count();   
                $page           = ($request->getParam('page', 0) > 0) ? $request->getParam('page') : 1;
                $limit          = 10; 
                $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));    
                $skip           = ($page - 1) * $limit;
                $posts          = Post::skip($skip)->take($limit)->orderBy('created_at', 'desc')->get();

        $categories = PostsCategories::all();
        
        
                return $this->view->render($response, 'website/blog.twig', [
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
                  'posts'=>$posts ,
                  'categories' =>$categories,
                  'searchView'=>$searchview,
                  'searchQuery'=>$request->getParam('search')
                ]);
        }
    
     
    public function article($request,$response,$args) {
       $id = rtrim($args['id'], '/');
       $article = Post::find($id);
       $categories = PostsCategories::all();
       $related = Post::where('categoryID', $article->categoryID)->get()->toArray();
       $comments = Comments::where('post_id', $id)->get()->toArray();
       return $this->container->view->render($response,'website/article.twig',[
           'article'=>$article,
           'comments' =>$comments,
           'categories' =>$categories,
           'related' =>$related
       ]);
    }
    

   public function categorie($request,$response,$args) {
       $id = rtrim($args['id'], '/');
       $categories = PostsCategories::all();
       $posts = Post::where('categoryID', $id)->get()->toArray();
       return $this->container->view->render($response,'website/blog.twig',[
           'posts'=>$posts ,
           'categories' =>$categories,
       ]);
    }    
    
    
    public function create($request,$response,$args) {
 
        $form        = validator::cleanify($request->getParams());
        $post_id     = $helper->clean($request->getParam('post_id'));
        
        // sv($form);
        
        
        /*
        *   Get the user info if he is logged in the website
        */
        if(isset($_SESSION['auth-user'])){
            $user_id = User::find($_SESSION['auth-user']);
            $email   = " ";
            $author  = " ";
        }
        
        /*
        *   Get the Form info if he is NOT logged in
        */
        else {
            $author = $form['author'];
            $email = $form['email'];
        }
       
        /*
        *    Adding the comment
        */
        Comments::create([
            'post_id' => $post_id,
            'author' => $author,
            'content' => $form['body'],
            'email' => $email,
            'approved' => 1
        ]);
        
        $this->flashsuccess('your Comment Added seccussfuly');
        return $response->withRedirect($this->router->pathFor('website.post',['id'=>$post_id]));
        
        
    }
    
}