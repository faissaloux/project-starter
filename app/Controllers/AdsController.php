<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

defined('BASEPATH') OR exit('No direct script access allowed');

class AdsController extends Controller {
    

    public $folder  = 'ads' ;
    public $model = 'Ads';
    public $route = [ 'index' => 'ads' , 'create' => 'ads.create'  ];
    public $control = __CLASS__ ;
    
    
    public $messages = [
        'created'           => 'Ads has been created successfully',
        'deleted'           => 'Ads has been deleted successfully',
        'updated'           => 'Ads has been updated successfully',
        'bulkDelete'        => 'All Adss deleted successfully',
        'cloned'            => 'Ads has been duplicated successfully',  
    ];
    
    public function saveData($content,$post,$update){          
        $content->name          = $post['name'];
        $content->image         = $post['image'];
        $content->url           = $post['url'];
        $content->statue        = $post['active'] == 'active' ? 1 : 0;;
        $content->htmlcode      = $post['codehtml'];
        $content->area          = $post['areaUndetected'] || '';
        $content->save();
        
    } 

}