<?php


/*
 * AFRASS 1.0.0 (2018-11-18, 19:18)
 *
 * Copyright (C) 2018 Soulaimane Takiddine 
 * SITE  : http://takiddine.com
 * EMAIL : takiddine.job@gmail.com
 * 
 */

defined('BASEPATH') OR exit('No direct script access allowed');

define('SCRIPTURL','http://starter.local/');
define('SCRIPTDIR', BASEPATH.'/');

return  [
    
    'app' => [
        'version'            => '1.0',
        'debug'              => true,
    ],
    
    'route' => [
        'admin'            => 'dashed_aitobitihgkh',
        'blog'              => 'blog',
    ],
    
    
    
    'db' => [
        'driver'             => 'mysql',
        'host'               => 'localhost',
        'name'               => 'madalil',
        'username'           => 'root',
        'password'           => '',
        'charset'            => 'utf8',
        'collation'          => 'utf8_general_ci',
        'strict'             => 'false',
        'prefix'             => 'na_'
    ],
    
        'views'              => '',
    
    'region' => [
            'time_format' => 'g:i a',
            'date_format' => 'm/d/Y',
            'datetime_separator' => ' ',
            'timezone' => null
    ],
    
    'settings'  => [
            'max_upload_size' => '5242880',
    ],
    
    
    'pay'  => [
        'mode'          => 'sandbox', // sandbox/live
        'client_id'     => 'AX5d1kpazzEitZjguYXvGfImA6xfv8EKWh2udD5bDww0sipG_ro6wkFU6CcF_DBdgj0fspBSnUqbaG4l',
        'client_secret' => 'EBYBEXeyPidw4tEbLKd5ELny6DZWFiGcW6G59aJ6-Z-P4Jwmf_z_KAvHa5k5jMe8x7Whsx2oB2vemBAZ',
        'return_url'    => SCRIPTURL.'checkpayement/',
        'cancel_url'    => SCRIPTURL.'checkpayement/'
    ],
    
    
    'url' => [
        'base'               => SCRIPTURL,
        'ads'                => SCRIPTURL.'uploads/undetected/',
        'admin_assets'       => SCRIPTURL.'admin_assets/',
        'website_assets'     => SCRIPTURL.'assets/',
        'assets'             => '/assets/',
        'avatars'            => SCRIPTURL.'uploads/avatar/',
        'pages'              => SCRIPTURL.'uploads/pages/',
        'posts'              => SCRIPTURL.'uploads/posts/',
        'products'           => SCRIPTURL.'uploads/products/',
        'general'            => SCRIPTURL.'uploads/general/',
        'slider'             => SCRIPTURL.'uploads/slider/',    
        'media'              => SCRIPTURL.'uploads/media/',    
        'uploads'            => SCRIPTURL.'uploads/',    
    ],
    
    'dir' => [
        'base'               => SCRIPTDIR,
        'avatars'            => SCRIPTDIR.'public/uploads/avatar/',
        'products'           => SCRIPTDIR.'public/uploads/products/',
        'ads'                => SCRIPTDIR.'public/uploads/undetected/',
        'posts'              => SCRIPTDIR.'public/uploads/posts/',
        'pages'              => SCRIPTDIR.'public/uploads/pages/',
        'general'            => SCRIPTDIR.'public/uploads/general/',
        'slider'             => SCRIPTDIR.'public/uploads/slider/',
        'media'              => SCRIPTDIR.'public/uploads/media/',
    ],

    'twitter' => [
        'OAUTH_ACCESS_TOKEN'               => '885655391614455808-5w8kQvXvtTEX1e0KmRxNXZOX66FMaXr',
        'OAUTH_ACCESS_TOKEN_SECRET'        => 'OOK0rQdxsTeBpnoQL0lpKox9LbcNLuR099fwc1eJeKblz',
        'CONSUMER_KEY'                     => 'eC6F8S07bE1C8bBf0uz78PmRM',
        'CONSUMER_SECRET'                  => 'AXfjU1mNdGM9mIJ6vpDIfwgO1Fyh2Yq0BYZLpMAhkxk1x6ChZY',
    ],


    'facebook' => [
        'OAUTH_ACCESS_TOKEN'               => '521567395024176',
        'OAUTH_ACCESS_TOKEN_SECRET'        => '46e646b839d85c573218ce94c0d646c4',
    ],
    
];


