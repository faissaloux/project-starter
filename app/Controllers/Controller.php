<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use JasonGrimes\Paginator;
use TwitterAPIExchange;
use \App\Helpers\Helper;
use \App\Helpers\Validator ;
use \App\Helpers\Uploader\Uploader;
use \App\Helpers\Flash;

defined('BASEPATH') OR exit('No direct script access allowed');

class Controller {

    // Page View Settings
    public $limit = 5;
	public $page = 1;
	public $where = [];
    public $whereIn = [];
	public $order = ['id','desc'];
	public $select = [];
	public $join = '';
	public $with = [];
    
    // Name Spacing
	private $modelSpace = '\\App\\Model\\';
	private $controllerSpace = '\\App\\Controllers\\';
    
    // Tools & Helpers
    protected $container;
    protected $helper;
    protected $lang;
    protected $validator;
    
    

    
    // init the Controller
    public function __construct($container){
       $this->container         = $container; 
       $this->lang              = isset($_SESSION['lkkk']);
       $this->validator         = new Validator();
       $this->helper            = new Helper();
       $this->uploader          = new Uploader();
        
    } 
    
    
    
    // Call a controller
    public function controller( $control = false ) {
        if($control){
              return '\\App\\Controllers\\' . ucfirst($control);
        }
        if($this->control) {
            return $this->control;
        }
        return false;
    }
    
    
    // Call a Model
    public function init( $model = false ) {
        if($model){
              return '\\App\\Models\\' . ucfirst($model);
        }
        if($this->model) {
            return '\\App\\Models\\' . ucfirst($this->model);
        }
        return false;
    }
    
    
    

    
    public function dir($dir){
       return $this->container->conf['dir.'.$dir];
    }
    public function url($url){
        return $this->container->conf['url.'.$url];
    }
    
    public function flash($message, $type = 'success'){
        return $_SESSION['flash'][$type] = $message;
    }
    
    public function flasherror($message){
        return $this->flash->addMessage('error',$message);
    } 
    
    public function flashsuccess($message){
        return $this->flash->addMessage('success',$message);
    } 
    
    
    public function __get($name){
        return $this->container->$name;
    }
    
    
    
    
    public function AutoShareTwitter(){
        
        
         
        $settings = [
            'oauth_access_token',
            'oauth_access_token_secret' ,
            'consumer_key' ,
            'consumer_secret' , 
        ];
        $settings = array_combine($settings,$this->container->twitter);
        
        
        $postfields = array(
          'status' => "script test allah allah",
        );	

        $url = 'https://api.twitter.com/1.1/statuses/update.json';

        $requestMethod = 'POST';
        $twitter = new TwitterAPIExchange($settings);
        $fullResponse = $twitter->buildOauth($url, $requestMethod)
                        ->setPostfields($postfields)
                        ->performRequest();
      

    }

    
    public function AutoShareFacebook(){
        
        $fb = new Facebook\Facebook([
         'app_id' => 'xxxxxxxxxx',
         'app_secret' => 'xxxxxxxxxx',
         'default_graph_version' => 'v2.2',
        ]);
        
    }
    
    /************************ MADE MY LIFE EASY ********************/

    public function index($request,$response) {
        $r = $this->paginate($this->limit);
        return $this->view->render($response, 'admin/'.$this->folder.'/index.twig', ['content'=>$r[0],'pagination'=>$r[1]]); 
    }

    public function paginate($limit){
        
        if($this->init()) {
            $helper         = $this->helper;
            $model          = $this->init();
            $count          = $model::count();  
            $page           = ( isset($_GET['page']) > 0) ? $_GET['page'] : 1;
            $lastpage       = (ceil($count / $limit) == 0 ? 1 : ceil($count / $limit));
            $skip           = ($page - 1) * $limit;
            $result         = $model::skip($skip)->take($limit)->orderBy('created_at', 'desc')->get();
            $search         = validator::cleanify(isset($_GET['q']));
            $urlPattern     = !empty($search) ? "?search=$search&page=(:num)" : "?page=(:num)"  ;
            $paginator      = new Paginator($count, $limit, $page, $urlPattern);
            return [$result,$paginator];
        }

    }
    
    public function create($request,$response) {
            return $this->container->view->render($response,'admin/'.$this->folder.'/create.twig');
    }   
    
    
    
    public function edit($request,$response,$args) {
 
        $content = $this->check($this->init(),rtrim($args['id'], '/'));
                        
        if($content){
             return $this->container->view->render($response,'admin/'.$this->folder.'/edit.twig',compact('content'));
        }
        
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor($this->route['index']));
           
    }
    
    public function store($request,$response,$args){
        $modelClass = $this->init();
        
        if(class_exists($modelClass)){
            $content = new $modelClass;
            $this->saveData($content,validator::cleanify($request->getParams()),false);
            $this->flashsuccess($this->messages['created']);  
        }
        
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor($this->route['index']));
    }
    
    public function update($request,$response,$args){
        $modelClass = $this->init();
        $id = rtrim($args['id'], '/');
        if(is_numeric($id)){
            if(class_exists($modelClass)){
                $content = $modelClass::find($id);
                if($content) {   
                    $this->saveData($content,validator::cleanify($request->getParams()),'update');
                    $this->flashsuccess($this->messages['updated']);  
                }
            }
        }
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor($this->route['index']));
    }
      
    
    
    public function  clone($request,$response,$args) {
        if($this->duplicate($this->init(),rtrim($args['id'], '/'))){
            $this->flashsuccess($this->messages['cloned']);  
        }
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor($this->route['index']));
    }  
    
    
    
    public function delete($request,$response,$args) {
        
        if($this->remove($this->init(),rtrim($args['id'], '/'))){
            $this->flashsuccess($this->messages['deleted']);  
        }
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor($this->route['index']));
    }    
    
    
    
    
    
    public function bulkdelete($request,$response) {
        $modelClass = $this->init();
        if(class_exists($modelClass)){
            if( $modelClass == 'User') { $modelClass::where('statue', '!=', 'supper')->delete(); }
            else { $modelClass::truncate(); }
            $this->flashsuccess($this->messages['bulkDelete']);  
        }
        return $response->withStatus(302)->withHeader('Location', $this->router->urlFor($this->route['index']));
    }  
    

    
    

    public function multiaction($request,$response){
        $modelClass = $this->init();
        $route =  $response->withStatus(302)->withHeader('Location', $this->router->urlFor($this->route['index']));
        $ids = explode(',',$request->getParam('list')) ?? [];
        $action = $request->getParam('action');
        if(!empty($ids)){
           
            switch($action){
                    
                case 'delete':
                    $modelClass::whereIn('id', $ids)->delete(); 
                    $this->flashsuccess($this->messages['multi.delete']);  
                    return $route;
                    break;
                    
                case 'duplicate':
                    foreach($ids as $id ){
                        $this->duplicate($modelClass,$id);
                    }
                    return $route;


            }
        }
        return $route;
    }
    
    

    
    public function check($model,$id){
         return (class_exists($model) and is_numeric($id)) ?  $model::find($id) ?? false : false;
    }
         

    public function duplicate($model,$id){
        $model = $this->check($model,$id);
        return $model ? ($new = $model->replicate() AND $new->save()) : false;   
    }
    
    public function remove($model,$id){
        $model = $this->check($model,$id);
        return $model ? $model->delete() : false;
    }
    
    
    public function truncate($model,$id){
        $model = $this->check($model,$id);
        return $model ? $model::truncate() : false;
    }
                
    
}
