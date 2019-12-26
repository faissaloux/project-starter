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
$app->group('/dashboard', function () use($app) {

    
    // static pages
    $this->get('[/]', 'Home:home')->setName('admin.index');
    $this->get('/account[/]', 'Home:account')->setName('account');
    $this->any('/beside-slider[/]', settings::class .':slider')->setName('beside-slider');

    
    
    // Coupons System
    $this->group('/coupons', function () {
        $this->get('[/]', 'Coupons:index')->setName('coupons');
        $this->get('/create[/]', 'Coupons:create')->setName('coupons.create');
        $this->post('/store[/]', 'Coupons:store')->setName('coupons.store');        
        $this->get('/bulkdelete[/]', 'Coupons:bulkdelete')->setName('coupons.bulkdelete');
        $this->get('/multiaction[/]', 'Coupons:multiaction')->setName('coupons.multiaction');
        $this->get('/edit/{id}[/]', 'Coupons:edit')->setName('coupons.edit');
        $this->post('/update/{id}[/]', 'Coupons:update')->setName('coupons.update');
        $this->get('/delete/{id}[/]', 'Coupons:delete')->setName('coupons.delete');
        $this->get('/clone/{id}[/]', 'Coupons:clone')->setName('coupons.clone');
    });
    
    // shipping Methods System
    $this->group('/shipping', function () {
        $this->get('[/]', 'Shipping:index')->setName('shipping');
        $this->get('/create[/]', 'Shipping:create')->setName('shipping.create');
        $this->post('/store[/]', 'Shipping:store')->setName('shipping.store');        
        $this->get('/bulkdelete[/]', 'Shipping:bulkdelete')->setName('shipping.bulkdelete');
        $this->get('/multiaction[/]', 'Shipping:multiaction')->setName('shipping.multiaction');
        $this->get('/edit/{id}[/]', 'Shipping:edit')->setName('shipping.edit');
        $this->post('/update/{id}[/]', 'Shipping:update')->setName('shipping.update');
        $this->get('/delete/{id}[/]', 'Shipping:delete')->setName('shipping.delete');
        $this->get('/clone/{id}[/]', 'Shipping:clone')->setName('shipping.clone');
    });
    
    // Payment Methods System
    $this->group('/payments', function () {
        $this->get('[/]', 'PaymentMethods:index')->setName('payments');
        $this->get('/create[/]', 'PaymentMethods:create')->setName('payments.create');
        $this->post('/store[/]', 'PaymentMethods:store')->setName('payments.store');        
        $this->get('/edit/{id}[/]', 'PaymentMethods:edit')->setName('payments.edit');
        $this->post('/update/{id}[/]', 'PaymentMethods:update')->setName('payments.update');
        $this->get('/activation/{id}[/]', 'PaymentMethods:activate')->setName('payments.activate');
    }); 
    
    // Ads System
    $this->group('/ads', function () {
        $this->get('[/]', 'Ads:index')->setName('ads');
        $this->get('/create[/]', 'Ads:create')->setName('ads.create');
        $this->post('/store[/]', 'Ads:store')->setName('ads.store');
        $this->get('/bulkdelete[/]', 'Ads:bulkdelete')->setName('ads.bulkdelete');
        $this->get('/multiaction[/]', 'Ads:multiaction')->setName('ads.multiaction');
        $this->get('/edit/{id}[/]', 'Ads:edit')->setName('ads.edit');
        $this->post('/update/{id}[/]', 'Ads:update')->setName('ads.update');
        $this->post('/delete/{id}[/]', 'Ads:delete')->setName('ads.delete');
        $this->get('/clone/{id}[/]', 'Ads:clone')->setName('ads.clone');
    });
    
    // Slider System
    $this->group('/slider', function (){
       $this->get('[/]', 'Slider:index')->setName('slider');
       $this->get('/create', 'Slider:create')->setName('slider.create');
       $this->post('/store', 'Slider:store')->setName('slider.store');
       $this->get('/bulkdelete[/]', 'Slider:bulkdelete')->setName('slider.bulkdelete');       
       $this->get('/edit/{id}[/]', 'Slider:edit')->setName('slider.edit');
       $this->post('/update/{id}[/]', 'Slider:update')->setName('slider.update');
       $this->post('/delete/{id}[/]', 'Slider:delete')->setName('slider.delete');
       $this->get('/clone/{id}[/]', 'Slider:clone')->setName('slider.clone');
    });

    // Pages System
    $this->group('/pages', function (){
        $this->get('[/]', 'Pages:index')->setName('pages');
        $this->any('{id}[/]', 'Pages:create')->setName('pages.view');
        $this->get('/create[/]', 'Pages:create')->setName('pages.create');
        $this->post('/store', 'Pages:store')->setName('pages.store');
        $this->get('/edit/{id}[/]', 'Pages:edit')->setName('pages.edit');
        $this->post('/update/{id}[/]', 'Pages:update')->setName('pages.update');
        $this->get('/delete/{id}[/]', 'Pages:delete')->setName('pages.delete');
        $this->get('/clone/{id}[/]', 'Pages:clone')->setName('pages.clone');
        $this->get('/bulkdelete[/]', 'Pages:bulkdelete')->setName('pages.bulkdelete');
        $this->post('/multiaction[/]', 'Pages:multiaction')->setName('pages.multiaction');
    });
    
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

    // Orders System
    $this->group('/orders', function (){
        $this->get('[/]', 'Orders:index')->setName('orders');
        $this->any('/edit/{id}[/]', 'Orders:edit')->setName('orders.edit');
        $this->any('/delete/{id}[/]', 'Orders:delete')->setName('orders.delete');
        $this->get('/clone[/]', 'Orders:clone')->setName('orders.clone');
        $this->get('/bulkdelete[/]', 'Orders:bulkdelete')->setName('orders.bulkdelete');
    });

    // Menu System
    $this->group('/menus', function (){
        $this->get('[/]', 'Menus:index')->setName('menus');
        $this->get('/create[/]', 'Menus:create')->setName('menus.create');
        $this->any('/edit/{id}[/]', 'Menus:edit')->setName('menus.edit');
        $this->any('/delete/{id}[/]', 'Menus:delete')->setName('menus.delete');
        $this->any('/bulkdelete[/]', 'Menus:bulkdelete')->setName('menus.bulkdelete');
    });
       
    // Products system
    $this->group('/products', function (){
        $this->get('[/]', 'Products:index')->setName('products');
        $this->get('/create[/]', 'Products:create')->setName('products.create');
        $this->post('/store[/]', 'Products:store')->setName('products.store');
        $this->get('/bulkdelete[/]', 'Products:bulkdelete')->setName('products.bulkdelete');
        $this->post('/multiaction[/]', 'Products:multiaction')->setName('products.multiaction');
        $this->get('/edit/{id}[/]', 'Products:edit')->setName('products.edit');
        $this->post('/update/{id}[/]', 'Products:update')->setName('products.update');
        $this->post('/delete/{id}[/]', 'Products:delete')->setName('products.delete');
        $this->get('/clone/{id}[/]', 'Products:clone')->setName('products.clone');
        
        // products cateogies
        $this->group('/categories', function (){
            $this->any('[/]', productscats::class .':index')->setName('products.categories');
            $this->any('/edit/{id}[/]', productscats::class .':edit')->setName('products.categories.edit');
            $this->get('/delete/{id}[/]', productscats::class .':delete')->setName('products.categories.delete');
        });
    });
    
    // Comments System
    $this->group('/comments', function (){
       $this->get('[/]', 'Comments:index')->setName('comments');
       $this->any('/edit/{id}[/]', 'Comments:edit')->setName('comments.edit');
       $this->get('/delete/{id}[/]', 'Comments:delete')->setName('comments.delete');
       $this->get('/bulkdelete[/]', 'Comments:bulkdelete')->setName('comments.bulkdelete');
       $this->get('/multiaction[/]', 'Comments:multiaction')->setName('comments.multiaction');
    });
    
    // Media System
    $this->group('/media', function (){
        $this->get('[/]', 'Media:index')->setName('media');
        $this->any('/view/{id}[/]', 'Media:view')->setName('media.view');
        $this->any('/upload[/]', 'Media:upload')->setName('media.upload');
        $this->any('/delete[/]', 'Media:delete')->setName('media.delete');
        $this->get('/bulkdelete[/]', 'Media:bulkdelete')->setName('media.bulkdelete');
        $this->any('/uploader[/]', 'Media:modal_uploader')->setName('media.modal_uploader');
        $this->get('/download/{id}[/]', 'Media:download')->setName('media.download');
        $this->get('/load[/]', 'Media:load')->setName('media.load');
    });
    
    // Faqs System
    $this->group('/faqs', function (){
        $this->get('[/]', 'Faqs:index')->setName('faqs');
        $this->get('/create[/]', 'Faqs:create')->setName('faqs.create');
        $this->post('/store[/]', 'Faqs:store')->setName('faqs.store');
        $this->get('/edit/{id}[/]', 'Faqs:edit')->setName('faqs.edit');
        $this->post('/update/{id}[/]', 'Faqs:update')->setName('faqs.update');
        $this->get('/delete/{id}[/]', 'Faqs:delete')->setName('faqs.delete');
        $this->get('/duplicate/{id}[/]', 'Faqs:duplicate')->setName('faqs.duplicate');
        $this->get('/bulkdelete[/]', 'Faqs:bulkdelete')->setName('faqs.bulkdelete');
        $this->get('/multiaction[/]', 'Faqs:multiaction')->setName('faqs.multiaction');
        
        // Faqs Categories
        $this->group('/categories', function (){
            $this->any('[/]', faqs::class .':categories')->setName('faqs.categories');
            $this->any('/edit/{id}[/]', faqs::class .':categories_edit')->setName('faqs.cat.edit');
            $this->any('/delete/{id}[/]', faqs::class .':categories_delete')->setName('faqs.cat.delete');
            $this->any('/create[/]', faqs::class .':categories_create')->setName('faqs.cat.create');
        });
    });
    
    //  posts System
    $this->group('/posts', function (){
        $this->get('[/]', 'Posts:index')->setName('posts');
        $this->get('/create[/]', 'Posts:create')->setName('posts.create');
        $this->post('/store[/]', 'Posts:store')->setName('posts.store');
        $this->get('/edit/{id}[/]', 'Posts:edit')->setName('posts.edit');
        $this->post('/update/{id}[/]', 'Posts:update')->setName('posts.update');
        $this->get('/delete/{id}[/]', 'Posts:delete')->setName('posts.delete');
        $this->get('/clone/{id}[/]', 'Posts:clone')->setName('posts.clone');
        $this->get('/bulkdelete[/]', 'Posts:bulkdelete')->setName('posts.bulkdelete');
        $this->post('/multiaction[/]', 'Posts:multiaction')->setName('posts.multiaction');

        // posts categories
        $this->group('/categories', function (){
            $this->any('[/]', 'PostsCategories:index')->setName('posts.categories');
            $this->get('/edit/{id}[/]', 'PostsCategories:edit')->setName('posts.categories.edit');
            $this->post('/edit/{id}[/]', 'PostsCategories:edit')->setName('posts.categories');
            $this->get('/delete/{id}[/]', 'PostsCategories:delete')->setName('posts.categories.delete');
        });
    });
    
    // Contact Mail System
    $this->group('/mail', function (){
        $this->get('[/]', 'Mail:index')->setName('mail');
        $this->get('/edit/{id}[/]', 'Mail:edit')->setName('mail.edit');
        $this->get('/delete/{id}[/]', 'Mail:delete')->setName('mail.delete');
        $this->get('bulkdelete[/]', 'Mail:bulkdelete')->setName('mail.bulkdelete');
    });
    
    // DangerZone System
    $this->group('/dangerZone', function () {
        $this->get('[/]', 'DangerZone:index')->setName('dangerzone.index');
        $this->get('clean/{model}[/]', 'DangerZone:clean')->setName('dangerzone.clean');
    });   
    
    // Payment Method settings
    $this->group('/payement-mehtod', function () {
        $this->get('/paypal[/]', PaymentMethods::class .':paypal')->setName('paypal.view');
        $this->post('/paypal[/]', PaymentMethods::class .':paypalStore')->setName('paypal.store');
        $this->get('/stripe[/]', PaymentMethods::class .':stripe')->setName('stripe.view');
        $this->post('/stripe[/]', PaymentMethods::class .':stripeStore')->setName('stripe.store');
    });  
    
    // Settings System
    $this->group('/settings', function (){
        $this->get('[/]', settings::class .':index')->setName('settings');
        $this->post('', settings::class .':general')->setName('settings.general');
        $this->any('/home[/]', settings::class .':home')->setName('settings.home');
        $this->any('/account[/]', settings::class .':account')->setName('settings.account');
        $this->any('/footer[/]', settings::class .':footer')->setName('settings.footer');
        $this->any('/others[/]', settings::class .':others')->setName('settings.others');
        $this->any('/store[/]', settings::class .':store')->setName('settings.store');
        $this->any('/payments[/]', settings::class .':payments')->setName('settings.payments');
        $this->any('/payments/edit/paypal[/]', settings::class .':paypal')->setName('settings.paypal');
        $this->any('/payments/edit/stripe[/]', settings::class .':stripe')->setName('settings.stripe');
        $this->any('/payments/edit/bank[/]', settings::class .':bank')->setName('settings.bank');
        $this->any('/system-info[/]', settings::class .':system')->setName('settings.system');
    });
    


//    // Costumize
//    $this->group('/costumize', function () {
////        $this->get('[/]', DangerZone::class .':index')->setName('dangerzone.index');
////        $this->get('clean/{model}[/]', DangerZone::class .':clean')->setName('dangerzone.clean');
//    }); 
})->add( new App\Middleware\authMiddleware($container) );

    /*
    *    Authentication System
    */
    $app->group('/auth', function (){
        $this->post('/login[/]', 'Auth:login')->setName('login');
        $this->any('/recover[/]', 'Auth:recover')->setName('recover');
        $this->get('/logout[/]', 'Auth:logout')->setName('logout');
        $this->get('/reset[/]', 'Auth:resetPasswordGet')->setName('resetPassword');
        $this->post('/reset[/]', 'Auth:resetPasswordPost')->setName('postNewPassword');        
        $this->get('/rested', 'Auth:reseted')->setName('rested');        
    });


//   Middlewares
$app->add( new flash($container) );
$app->add( new old($container) );