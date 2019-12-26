<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\Ads;
use \App\Models\Media;
use \App\Classes\files;

defined('BASEPATH') OR exit('No direct script access allowed');

class MediaController extends Controller {
    
        
    public $route = [ 'index' => 'media' , 'create' => 'coupons.create'  ];
    public $model = 'Media';
    public $folder = 'media';
    
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
    
    
    
    
    public function load($request,$response){
    return Media::take(4)->orderBy('created_at', 'desc')->get()->toJson(JSON_PRETTY_PRINT);
    }
    
   
    
  
    public function upload($request,$response) {
       
        $dir  = $this->dir('media');
        $file = $_FILES['file'];
        $upload = $this->uploader->file($file)->dir($dir)->save();
        $uploded = Media::create([ 'name' => $upload->name, 'post_mime_type' => $upload->type ]);
        return json_encode(['url' => $this->url('media').$upload->name ,'id'  => $uploded->id ] );
    }
    
    
    
    
    

   
    // Delete a media element by ajax so there is no redirect
    public function delete($request,$response,$args) {
        
        // get the id
        $id = rtrim($_POST['id'], '/');
        
        // get the media 
        $media = Media::find($id);
        
        if($media){
            unlink($this->dir('media').$media->name);
            $media->delete();
        }
        
    }
    
    
    // Delete a media element by ajax so there is no redirect
    public function download($request,$response,$args) {
        
        // get the id
        $id = rtrim($args['id'], '/');
        
        // get the media 
        $media = Media::find($id);

        
        if($media){
            $file = $this->dir('media').$media->name;
            $this->helper->download($file);
        }
        
    }
    
   
}

