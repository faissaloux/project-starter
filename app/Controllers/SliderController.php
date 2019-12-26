<?php

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

defined('BASEPATH') OR exit('No direct script access allowed');

class SliderController extends Controller{
   
    public $route = [ 'index' => 'slider' , 'create' => 'slider.create'  ];
    public $model = 'Slider';
    public $folder = 'slider';
    
    public $messages = [
        'created'           => 'slider has been created successfully',
        'deleted'           => 'slider has been deleted successfully',
        'updated'           => 'slider has been updated successfully',
        'bulkDelete'        => 'All slides deleted successfully',
        'cloned'            => 'slider has been duplicated successfully',
    ];
    
    public function saveData($content,$post,$update){
        
        $up = $this->files;
        $file = $_FILES['image'];
        $dir = $this->dir('slider');
        
        if(!$update){
          $image = (isset($file) and !empty($file['name'])) ? $up->upload_avatar($dir,$file) :  '';
        }
        
        if($post['isAdChanged'] == 'true') {
            $image = (isset($file) and !empty($file['name'])) ? $up->upload_avatar($dir,$file) :  '';
            $old = $this->dir('slider').$slider->image; if(file_exists($old)) {unlink($old);}
        }
        
        $content->link = $post['link'];
        $content->image = $image;
        $content->save();
        
    }
    
  
}

