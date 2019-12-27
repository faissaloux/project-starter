<?php

defined('BASEPATH') OR exit('No direct script access allowed');
define('SCRIPTURL','http://starter.local/');
define('SCRIPTDIR', BASEPATH.'/');

return  [
    
    'app' => [
        'debug'              => true,
    ],
    
    
    'db' => [
        'driver'             => 'mysql',
        'host'               => 'localhost',
        'name'               => 'bassiri',
        'username'           => 'root',
        'password'           => '',
        'charset'            => 'utf8',
        'collation'          => 'utf8_general_ci',
        'strict'             => 'false',
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


