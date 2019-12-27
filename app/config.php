<?php

defined('BASEPATH') OR exit('No direct script access allowed');


// Getting the Base URL
if(!empty($_SERVER['HTTP_HOST'])){
   
    define('SCRIPTURL',$_SERVER['HTTP_HOST'].'/');

} else {
    
	if(!empty($_SERVER['SERVER_NAME'])){
       
        define('SCRIPTURL',$_SERVER['SERVER_NAME'].'/');
	}
}


define('SCRIPTDIR', BASEPATH.'/');

return  [
    
    'app' => [
        'debug'              => true,
    ],
    
    
      
    'db_live' => [
        'driver'             => 'mysql',
        'host'               => 'localhost',
        'name'               => 'medisozf_bassiri',
        'username'           => 'medisozf_bassiri',
        'password'           => '{bVXu~oD5z*P',
        'charset'            => 'utf8',
        'collation'          => 'utf8_general_ci',
        'strict'             => 'false',
        'prefix'             => 'na_'
    ],
    
    
    'db_sandbox' => [
        'driver'             => 'mysql',
        'host'               => 'localhost',
        'name'               => 'bassiri',
        'username'           => 'root',
        'password'           => '',
        'charset'            => 'utf8',
        'collation'          => 'utf8_general_ci',
        'strict'             => 'false',
        'prefix'             => 'na_'
    ],
    
    
    
    
    
    'url' => [
        'base'               => SCRIPTURL,
        'admin_assets'       => SCRIPTURL.'admin_assets/',
        'assets'             => '/assets/',
        'avatars'            => SCRIPTURL.'uploads/avatar/',
        'media'              => SCRIPTURL.'uploads/media/',    
        'uploads'            => SCRIPTURL.'uploads/',    
    ],
    
    'dir' => [
        'base'               => SCRIPTDIR,
        'avatars'            => SCRIPTDIR.'public/uploads/avatar/',
        'media'              => SCRIPTDIR.'public/uploads/media/',
    ],

];


