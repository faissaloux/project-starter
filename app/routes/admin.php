<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
// make namespace short

use \App\Controllers\settingsController as settings;

// flash
use \App\Middleware\flashMiddleware as flash;
use \App\Middleware\OldInputMidddleware as old;
    
    
// security , disable direct access
defined('BASEPATH') or exit('No direct script access allowed');


/*
*  Admin Routes
*/
$app->group('/', function () use($app) {

    
    $this->get('[/]',function(){
        echo 'kdkjdkjkdjd';
    });
    
    
    $this->get('/account[/]', 'Home:account')->setName('account');

    
    
    // users System
    $this->group('/users', function ( ) {
        $this->get('[/]', 'Users:index')->setName('users');
        $this->get('/create[/]', 'Users:create')->setName('users.create');
        $this->post('/store[/]', 'Users:store')->setName('users.store');
        $this->get('/export/csv[/]', 'Users:export_csv')->setName('usersToCsv');
        $this->get('/export/pdf[/]', 'Users:export_pdf')->setName('usersToPdf');        
        $this->post('/delete/{id}[/]', 'Users:delete')->setName('users.delete');
        $this->get('/activate/{id}[/]', 'Users:delete')->setName('users.activate');
        $this->get('/block/{id}[/]', 'Users:block')->setName('users.block');
        $this->get('/bulkdelete[/]', 'Users:bulkdelete')->setName('users.bulkdelete');
        $this->post('/multiaction[/]', 'Users:multiaction')->setName('users.multiaction');
        $this->any('/edit/{id}[/]', 'Users:edit')->setName('users.edit');
        $this->post('/update/{id}[/]', 'Users:update')->setName('users.update');
    });




})->add( new App\Middleware\authMiddleware($container) );


$app->group('/auth', function (){
    $this->post('/login[/]', 'Auth:login')->setName('login');
});


//   Middlewares
$app->add( new flash($container) );
$app->add( new old($container) );