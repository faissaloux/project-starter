<?php

/*!
 * AFRASS 1.0.0 (2018-11-18, 19:18)
 * http://takiddine.com
 * MIT licensed
 *
 * Copyright (C) 2018 Soulaimane Takiddine , http://takiddine.com
 */

defined('BASEPATH') or exit('No direct script access allowed');
     


return  [
    
    'flash' => [
        
        // AdsController
        '1' => 'Ad updated successfully',
        '2' => 'Ad successfully added',
        '3' => 'Ad successfully deleted',
        
        // CommentsController
        '4' => 'Comment successfully modified',
        '5' => 'Comment successfully deleted',
        
        // FaqsController
        '6' => 'Question added successfully',
        '7' => 'Your question has been successfully modified',
        '8' => 'Question successfully deleted',
        '9' => 'The question was successfully repeated',
        '10' => 'Please enter the name of the category and link',
        '11' => 'Classification updated successfully',
        '12' => 'Successfully deleted the label',
        '13' => 'Please enter the name of the category and link',
        '14' => 'The label name already exists',
        '15' => 'Label added successfully',
        
        // AuthController
        '21' => 'If the email you entered is registered we will receive a message in your mail thank you',
        '22' => 'Sorry this link is out of date',
        '23' => 'Please enter and confirm your password',
        '24' => 'Passwords do not match Please try again',

        
//        
//        
//        //CouponsController
//        '25' => 'تم حذف المقالة بنجاح',
//        '26' => 'تم تكرار المقالة بنجاح',
//        '27' => 'تم حذف كل الصفحات بنجاح',
//
//        //EmailController
//        '28' => 'اسم الموقع',
//        '29' => 'تم ارسال الإميل بنجاح',
//        '30' => 'تم حذف الإميل بنجاح',
//        '31' => 'تم حذف كل الإميلات بنجاح',
//
//        
//        
//        //MailController
//        '32' => 'تم حذف الرسالة بنجاح',
//
//        //MailListsController
//        '33' => 'تم الإشتراك في القائمة البريدية بنجاح',
//        '34' => 'الإميل الذي تم ادخاله خاطئ المرجوا التأكد منه والمحاولة من جديد',

        // MediaController
        '35' => 'Upload file',
        '36' => 'Delete',

        // OrdersController
        '37' => 'Order successfully deleted',

        // PagesController
        '38' => 'Page has been successfully updated',
        '39' => 'Page added successfully',
        '40' => 'Page deleted successfully',
        '41' => 'Page duplicated successfully',
        '42' => 'All Pages deleted successfully',
        '43' => 'Command executed successfully',

        
        
        // PermissionsController
        '44' => 'Please enter group name first',
        '45' => 'Group added successfully',
        '46' => 'Group modified successfully',
        '47' => 'Group deleted successfully',
        '48' => 'All groups were successfully deleted',

        // PostsCategoriesController
        '49' => 'Please enter the name of the label and link',
        '50' => 'The link should consist of Latin letters and numbers only',
        '51' => 'Label name already exists',
        '52' => 'Link to Category already exists', 
        '53' => 'Category added successfully',
        '54' => 'Category deleted successfully',
        '55' => 'Please enter the name of the label and link',      
        '56' => 'The link should consist of Latin letters and numbers only',
        '57' =>  'Category updated successfully',

        // PostsController
        '58' => 'Article added successfully',
        '59' => 'Article has been successfully modified',
        '60' => 'Article deleted successfully',
        '61' => 'Article repeated successfully',
        '62' => 'Command executed successfully',

        // ProductsCategoriesController
        '63' => 'Please enter the name of the label and link',
        '64' => 'The link should consist of Latin letters and numbers only',
        '65' => 'Label name already exists',
        '66' => 'Category Link already exists',
        '67' => 'Category added successfully',
        '68' => 'categorie deleted successfully',
        '69' => 'Please enter the name of the label and link',
        '70' => 'The link should consist of Latin letters and numbers only',
        '71' => 'Category updated successfully',
        

        // ProductsController
        '72' => 'Product has been successfully added',
        '73' => 'Product has been successfully updated',
        '74' => 'Product was successfully deleted',
        '75' => 'Product was successfully repeated',


        // settingsController
        '76' => 'Username is required',
        '77' => 'username must be letters and numbers only',
        '78' => 'Username is required',
        '79' => 'Email is incorrect',
        '80' => 'Information has been successfully updated',
        '81' => 'The current password you entered is wrong!',
        '82' => 'Please enter and confirm your new password',
        '83' => 'New passwords do not match, please try again',
        '84' => 'Password updated successfully',
        '85' => 'Information has been successfully updated',
        '86' => 'Information has been successfully updated', 
        '87' => 'Information has been successfully updated',
        '89' => 'Information has been successfully updated',
        '90' => 'Information has been successfully updated',

       // SliderController
       '91' => 'Slider successfully updated',
       '92' => 'Slider was successfully added',
       '93' => 'Slider successfully deleted',


       // UsersController
       '94' => 'All members were deleted successfully',
       '95' => 'Can not delete this member',
       '96' => 'Member deleted successfully',
       '97' => 'Member has been successfully activated',
       '98' => 'Member blocked successfully',
       '99' => 'Please enter username',
       '100' => 'Please enter email',
       '101' => 'Please enter password',
       '102' => 'Invalid username, only letters and numbers',
       '103' => 'Username already exists',
       '104' => 'Email is incorrect',
       '105' => 'Email is already used',
       '106' => 'An error occurred unexpectedly, please try again',
       '107' => 'Informations has been successfully modified',
       '108' => 'Command executed successfully',
  ],
    
    
    
    
    'MenuItems' => [
        '1' => ' top menu ',
        '2' => 'main menu ',
        '3' => 'footer menu 1 ',
        '4' => ' footer menu 2 ',
        '5'  => ' footer menu 3',
        '6'  => 'footer menu 4' ,
    ],

    'InboxPage' => [
            '1' => 'delete all messages',
        ],

    
    
    
    
    
    
    
    'lang' => 'en',
    
    'bread' => [
        '1' => 'Home',
    ],
    
   'panelang' => [
        '1' => 'A normal user',
        '2' => 'Manager',
        '3' => 'unknown',
        '4' => 'Enabled',
        '5' => 'Waiting for approval',
        '6' => 'forbidden',
        '7' => 'masculine',
        '8' => 'female',
        '9' => 'Not enabled',
        '10' => 'pending',
        '11' => '',
        '12' => '',
        '13' => '',
        '14' => '',
        '15' => '',
        '16' => '',
        '17' => '',
        '18' => '',
        '19' => '',
        '20' => '',
        '21' => '',
        '22' => '',
        '23' => '',
        '24' => '',
        '25' => '',
        '26' => '',
        '27' => '',
        '28' => '',
        '29' => '',
        '30' => '',
        '31' => '',
        '32' => '',
        '33' => '',
        '34' => '',
        '35' => '',
        '36' => '',
        '37' => '',
        '38' => '',
        '39' => '',
        '40' => '',
        '41' => '',
        '42' => '',
        '43' => '',
        '44' => '',
        '45' => '',
        '46' => '',
        '47' => '',
        '48' => '',
        '49' => '',
    ],
    
    
    
    'navbar' => [
        '1' => 'control panel',
        '2' => 'visite website',
        '3' => 'account settings',
        '4' => 'logout',
        '5'  => 'new',
        '6'  => 'user' ,
        '7'  => 'page',
        '8'  => 'post ',
        '9'  => 'product',
    ],
        
        
      'contact' => [
        '1' => 'inbox',
        '2' => 'when you recieve new email will appear here '
    ],
     
    
    
    
    
    'sidebar' => [
        '1'       => 'overview',
        '2'       => 'Messages',
        '3'       => 'users',
        '4'       => 'Media',
        '5'       => 'Pages',
        '6'       => 'posts',
        '7'       => 'Menus',
        '8'       => 'Ads',
        '9'       => 'Products',
        '10'      => 'store',
        '11'      => 'Faqs',
        '12'      => 'settings',
        '13'      => 'costumize',
        '14'      => 'Mail list',
        '15'      => 'Inbox',
        '16'      => 'roles',
        '18'      => 'products categories',
        '17'      => 'posts categories',
        '19'      => 'comments',
        '20'      => 'coupons',
        '21'      => 'faq categories',
        '22'      => 'general settings',
        '23'      => 'social media',
        '24'      => 'email',
        '25'      => 'users',
        '26'      => 'permalinks',
        '27'      => 'link accounts',
        '28'      => 'others',
        '29'      => 'home slider',
        '30'      => 'hero images',
        '31'      => 'home page',
        '32'      => 'footer',
        '33'      => 'orders',
        '34'      => 'calender',
    ],
    
    
    'others' => [
        '201' => 'Other settings ',
        '202' => 'create html / css / js codes at the top of site ',
        '203' => 'edit',
        '204' => 'create html / css / js tags at the bottom of the site ',
        '205' => 'edit ',
        '206' => 'do you need help !',
        '207' => 'The first box',
        '208' => 'Place in which codes you want to appear between and named ',
        '209' => '',
        '210' => 'The second field',
        '211' => 'Place in which codes you want to appear before marking',
        '212' => '',
        '213' => 'Attention',
        '214' => 'Before creating any code, make sure that it is from secure sites, create insecure codes that may affect the protection of your site'
    ],
    
    
    'Auau' => [
        '0' => 'username or password',
        '2' => 'please insert login info',
        '9' => 'password',
        '10' => 'login',
        '3' => 'Lost your password ؟',
        '4' => 'recover my password',
        '5' => 'insert your email & you follow the instructions sent to your email',
        '7' => 'recover my password',
        '8' => 'i remember your password , login',
        '11' => 'please insert the new password , and repeat it',
        '12' => 'the new password',
        '13' => 'repeat the new password',
        '14' => 'update the password'
    ],
    
    'home' => [
        '0' => 'welcome to control panel! ',
        '1' => 'we collected some links for you to help you start:',
        '2' => 'firsts steps !',
        '3' => 'write your first article',
        '4' => 'create the new page',
        '5' => 'more !',
        '6' => 'site settings',
        '7' => 'account settings',
        '8' => 'products total',
        '9' => 'pages total',
        '10' => 'users total',
        '11' => 'emails total',
        '12' => 'likes',
        '13' => 'subscriber',
        '14' => 'subscriber',
        '15' => 'follower',
        '16' => 'general info',
        '17' => 'control panel version',
        '18' => 'php version',
        '19' => 'mysql version',
        '20' => 'files size',
        '21' => 'database size',
        '22' => 'weather',
        '23' => 'temperature',
        '24' => 'Humidity',
        '25' => 'winds',
        '26' => 'sunrise',
        '27' => 'sunset'
    ],
    
    'postsCategories' => [
        '0' => 'categories',
        '1' => 'total categories ',
        '2' => 'categorie',
        '3' => 'add new categorie',
        '4' => 'categorie name',
        '5' => 'categorie link',
        '6' => 'add categorie',
        '7' => 'name',
        '8' => 'link',
        '9' => 'total posts',
        '10' => 'edit',
        '11' => 'preview',
        '12' => 'delete',
        '13' => 'save changes',
        '14' => 'total products',
        '15' => 'edit categorie',
    ],   
   
   

   
    
    'Sliders' => [
        '0' => 'image',
        '1' => 'created at',
        '2' => 'edit',
        '3' => 'delete',
        '4' => 'add new slider',
        '5' => 'slider',
        '6' => 'add new slider',
        '7' => 'slider image',
        '8' => 'slider link',
        '9' => 'choose image',
        '10' => 'save changes',
        '11' => 'create slider',
        '12' => 'edit slider',
        '13' => 'preview image',
        '14' => 'delete image',
    ],    
   
   
   
   
   
   
   
    'users' => [
        '1' => 'members',
        '2' => 'member',
        '3' => 'total members : ',
        '4' => 'add new member',
        '5' => 'delete all members',
        '6' => 'download pdf ',
        '7' => 'download csv',
        '8' => 'search for users',
        '9' => 'search',
        '91' => 'seach for users by email / username',
        '10' => 'no result found',
        '11' => 'please try again',
        '15' => 'username',
        '16' => 'email',
        '17' => 'created at',
        '18' => 'role',
        '19' => 'statue',
        '20' => 'edit',
        '22' => 'search for users',
        '23' => 'export'
    ],
    
    
    'posts' => [
        '1' => 'posts',
        '2' => 'add new post',
        '3' => 'delete all posts ',
        '4' => 'you don\'t have any posts yet , start now ',
        '5' => 'add new post',
        '7' => 'title',
        '9' => 'created at',
        '10' => 'edit',
        '11' => 'view post',
        '12' => 'edit post',
        '13' => 'delete post',
        '14' => 'duplicate',
        '15' => 'title without title'
    ],
    
    'media' => [
        '0' => 'media',
        '1' => 'upload new file',
        '2' => 'delete all media ',
        '3' => 'it looks like you didn\'t upload any media yet',
        '4' => 'upload new file',
        '5' => 'file',
        '6' => 'type file',
        '7' => 'uploaded at',
        '8' => 'file size',
        '9' => 'direct link',
        '10' => 'download',
        '11' => 'delete',
        '12' => 'click here',
        '13' => 'download file',
        '14' => 'delete',
        '15' => 'file name',
        '16' => 'type file',
        '17' => 'uploaded at',
        '20' => 'download',
        '21' => 'delete',
        '23' => 'uploader'
    ],
    
    
    
    'inbox' => [
        '0' => 'inbox',
        '1' => 'it looks like you didnt send any emails yet, start now',
        '2' => 'when you send emails will apear here',
        '3' => 'email',
        '4' => 'to :',
        '5' => 'sent ',
        '6' => 'edit',
        '7' => 'preview ',
        '8' => 'delete',
        '9' => 'send new email',
        '10'=> 'delete all emails'
    ],
    
    'ads' => [
        '1' => 'ads',
        '2' => 'create new ad',
        '3' => 'delete all ads',
        '5' => 'hello, you don\'t have any ads yet, create one',
        '6' => 'create new ad',
        '7' => 'title ad',
        '8' => 'created at',
        '9' => 'statue',
        '10' => 'edit',
        '11' => 'edit',
        '12' => 'delete',
        '13' => '#',
    ],
    
    'comment' => [
        '0' => 'comments',
        '2' => 'delete all comments',
        '3' => 'author',
        '4' => 'comment',
        '5' => 'created at',
        '6' => 'edit',
        '7' => 'view comment',
        '8' => 'edit comment ',
        '9' => 'delete comment'
    ],
    
    
    'orders' => [
        '2' => 'orders',
        '4' => 'total orders : ',
        '3' => 'orders',
        '5' => 'delete all orders',
        '6' => 'when you recieve new order , will apear here.',
        '7' => 'order',
        '8' => 'ordered att',
        '9' => 'statue',
        '10' => 'total'
    ],
    
    'faqs' => [
        '3' => 'faq',
        '4' => 'create new faq',
        '5' => 'delete all faq',
        '6' => 'start creating faq questions now',
        '7' => 'the faq is empty start creating new questions',
        '8' => 'create new faq',
        '11' => 'created at : ',
        '12' => 'edit ',
        '13' => 'delete ',
        '14' => 'duplicate'
    ],
    

    'emailist' => [
        '405' => 'emai list',
        '406' => 'delete all emails',
        '408' => 'when people subscribe , there emails will apear here',
        '409' => 'email',
        '410' => 'subscribed att'
    ],
    
    
    'menus' => [
        '37' => 'menus',
        '38' => 'delete all menus',
        '39' => 'menu name',
        '40' => 'create menu name',
        '41' => 'menu name',
        '42' => 'create menu',
        '43' => 'name',
        '44' => 'link',
        '45' => 'edit',
        '46' => 'chose a menu to edit',
        '47' => '— chose —',
        '48' => 'create new menu',
        '49' => 'pages',
        '50' => 'add',
        '51' => 'posts',
        '52' => 'costum link',
        '53' => 'text link',
        '54' => 'link',
        '55' => 'add',
        '56' => 'save menu',
        '57' => 'menu location',
        '64' => 'delete menu',
        '65' => 'Display location',
        '66' => 'or'
    ],
    
    
   'pages' => [
        '71' => 'pages',
        '72' => 'new page',
        '73' => 'delete all pages',
        '74' => 'you dont have any pages yet, create page now',
        '76' => 'create new page',
        '79' => 'page title',
        '80' => 'page author',
        '81' => 'created at',
        '82' => 'edit',
        '83' => 'page without title',
        '84' => 'view page',
        '85' => 'edit page',
        '86' => 'delete page',
        '87' => 'duplicate'
    ],
    
    

    'products' => [
        '232' => 'products',
        '234' => 'total products',
        '231' => 'product',
        '235' => 'create new product',
        '236' => 'delete all products',
        '237' => 'home',
        '238' => 'products',
        '240' => 'start adding new products',
        '241' => 'create new products',
        '242' => 'search about products',
        '243' => 'search',
        '244' => 'no result was found',
        '245' => 'please try again , use more general keywordss',
        '247' => 'product name',
        '248' => 'created at',
        '249' => 'price',
        '250' => 'categorys',
        '251' => 'edit',
        '252' => 'preview ',
        '253' => 'edit ',
        '254' => 'delete ',
        '255' => 'duplicate',
        '256' => 'search about product'
    ],
    
            
    'editproducts' => [
        '1' => 'edit product',
        '2' => 'product name',
        '3' => 'slug',
        '4' => 'description',
        '5' => 'price',
        '6' => 'discount price',
        '7' => 'gallery',
        '8' => 'category',
        '9' => 'delete',
        '10' => 'save changes',
        '11' => 'chose image',
        '12' => 'chose images',
        '13' => 'gallery',
        '14' => 'not defined',
    ],
    
    'settings' => [
        '114' => 'general settings',
        '115' => 'settings',
        '116' => 'download database',
        '117' => 'edit settings',
        '118' => 'site info',
        '119' => 'please insert this info carefuly',
        '120' => 'site logo',
        '121' => 'chose ',
        '122' => 'favicon',
        '123' => 'chose image',
        '124' => 'site name',
        '125' => 'tagline',
        '126' => 'describe your website in few words',
        '127' => 'meta keywords',
        '128' => 'website statue',
        '129' => 'online',
        '130' => 'maintenace',
        '133' => 'allow comments',
        '134' => 'allow comments',
        '135' => 'disable comments',
        '136' => 'control panel language',
        '137' => 'arabic',
        '138' => 'english',
        '139' => 'phone number',
        '140' => 'email',
        '141' => 'adresse',
        '142' => 'Google Analitycs code',
        '143' => 'app link in google store',
        '144' => 'app link in apple store',
        '145' => 'edit information',
        '146' => 'do you need help !',
        '147' => 'site logo',
        '148' => 'logo in the pages header',
        '149' => 'favicon site',
        '150' => 'favicon is a small, iconic image that represents your website',
        '151' => 'keywords',
        '152' => 'Keywords are ideas and topics that define what your content is about. In terms of SEO',
        '153' => 'Google Analitycs code',
        '154' => 'you can use your google Analitycs code for trakcing visitors',
        '155' => 'preview ad',
        '156' => 'delete image '
    ],
    
    
    
    'inboxcreate' => [
        '300' => 'create new email',
        '301' => 'reciever email',
        '302' => 'email title',
        '303' => 'send email ',
        '304' => 'do you need help !',
        '305' => 'reciever email',
        '306' => 'the email of the person that will recieve the email',
        '307' => 'email title ',
        '308' => 'the title of the email you want to send',
        '309' => 'message',
        '310' => 'the main message you want to send',
        '311' => 'send email',
        '312' => 'click on the blue button to send the email'
    ],
    
    'mediauploader' => [ 
        '1' => 'upload files',
        '2' => 'media library',
        '3' => 'chose file',
        '4' => 'choose image'
    ],
    
    
    'pagescreate' => [
        '91' => 'create new page',
        '92' => 'create new page',
        '93' => 'title page',
        '94' => 'publish page ',
        '97' => 'featured image',
        '98' => 'chose image'
    ],
    
    'postscreate' => [
        '2' => 'create new post ',
        '4' => 'post title',
        '5' => 'publish post',
        '6' => 'category',
        '7' => 'not defined',
        '8' => 'feautred image ',
        '9' => 'chose image'   
    ],
    
    'commentsedit' => [
        '2' => 'edit comment',
        '3' => 'comment',
        '4' => 'update comment'
    ],
    
    'createads' => [
        '2' => 'create new ad',
        '3' => 'activate ad',
        '4' => 'ad title',
        '5' => 'title , is not important , but it is good for you to reconize ads .',
        '6' => 'ad image',
        '7' => 'ad image',
        '8' => 'chose image',
        '9' => 'ad link',
        '10' =>  '- or code -',
        '11' => 'ads script here',
        '12' => 'create ad',
        '13' => 'do you need help !',
        '14' => 'activate ad',
        '15' => 'choose if you want to show the ads or not',
        '16' => 'title ad',
        '17' => 'title , is not important , but it is good for you to reconize ads .',
        '18' => 'ad link',
        '19' => 'make sure that the link start with',
        '20' => 'ad image',
        '21' => ' accept only this extenstions : ',
        '22' => 'jpeg,png,gif',
        '23' => 'custom ad code',
        '24' => 'you can ad google adsense code or any html code',
        '25' => 'attention ',
        '26' => 'when you add custom code ad , the image & link will be ignored ',
        '27' => 'ads categorie ',
        '28' => 'not defined',
        '35' => 'preview ad',
        '36' => 'delete image '
    ],
    

    
    'Adsedit' => [
        '2' => 'edit ad',
        '3' => 'activate ad',
        '4' => 'ad title',
        '5' => 'title , is not important , but it is good for you to reconize ads .',
        '6' => 'ad image',
        '7' => 'ad image',
        '8' => 'chose image',
        '9' => 'link',
        '10' => '- or code -',
        '11' => 'ads script here',
        '12' => 'you can add you google adsense code here',
        '13' => 'edit ad',
        '14' => 'تحدد مكان ad :',
        '22' => 'preview ad',
        '23' => 'delete image ',
        '24' => 'delete image'
    ],
    
    
    'postsedit' => [
        '2' => 'edit post',
        '3' => 'edit post ',
        '4' => 'post category',
        '5' => 'not defined',
        '6' => 'featured image',
        '7' => 'delete image ',
        '8' => 'chose image'
    ],
    
    
    'permissions' => [
        '320' => 'roles',
        '321' => 'delete all المجموعات',
        '322' => 'group name',
        '323' => 'edit',
        '324' => 'edit ',
        '325' => 'delete ',
        '326' => 'create new groupe',
        '327' => 'create goupr',
        '328' => 'how to add new groupe',
        '329' => 'قم بcreate اسم المجموعة في خانة create مجموعة newة واضغط على create المجموعة',
        '331' => 'الآن بعد ان أنشأت المجموعة ، ستظهر لك في أول الجدول على اليمين ',
        '333' => 'click on edit ',
        '335' => 'واعطاء الصلاحيات لهذه المجموعة ',
        '336' => 'ما الغاية من انشاء مجموعات للعضويات ؟',
        '337' => 'انت بحاجة اليها من أجل اعطاء all عضو typeاً من الصلاحية ، على سبيل المثال ، تallف أشخاص بcreate المقالات فقط بموقعك ، دون المساس بsettings ، ودون التحكم ورؤية الأشياء الأخرى'
    ],
    
    
    
    'usersedit' => [
        '2' => 'users ',
        '3' => 'edit account',
        '4' => 'avatar',
        '5' => 'chose image',
        '6' => 'allowed types : png, jpg',
        '7' => 'edit user info',
        '8' => 'all information are in safe hands',
        '9' => 'username:',
        '10' => 'full name:',
        '11' => 'email ',
        '12' => 'phone :',
        '13' => 'country:',
        '14' => 'birth day:',
        '15' => 'gender:',
        '16' => 'male',
        '17' => 'female',
        '18' => 'description :',
        '19' => 'edit password',
        '20' => 'remember',
        '21' => 'create strong password',
        '22' => 'socila media links',
        '23' => 'facebook',
        '24' => 'twitter',
        '25' => 'youtube',
        '26' => 'update settings',
        '27' => 'account',
        '28' => 'block account',
        '29' => 'activate account',
        '30' => 'delete account',
        '31' => 'set user as :',
        '32' => 'مستخدم عادي',
        '33' => 'مدير',
        '34' => 'مسؤول',
        '35' => 'author',
        '36' => 'مراقب',
        '37' => 'download info',
        '38' => 'download pdf',
        '39' => 'download csv'
    ],
    
    
    'productsCreate' => [
        '260' => 'create new product',
        '261' => 'product name',
        '262' => 'link',
        '263' => 'desciption',
        '264' => 'price',
        '265' => 'the regural price',
        '266' => 'create new product',
        '267' => 'feautred image',
        '268' => 'chose feautred image',
        '269' => 'product gallery',
        '270' => 'chose image',
        '271' => 'product category',
        '272' => 'not defined'
    ],

    
    'Adsedit' => [
        '2' => 'edit ad',
        '3' => 'activate ad',
        '4' => 'ad title',
        '5' => 'title , is not important , but it is good for you to reconize ads .',
        '6' => 'ad image',
        '7' => 'ad image',
        '8' => 'chose image',
        '9' => 'link',
        '10' => '- or code -',
        '11' => 'ads script here',
        '12' => 'you can add you google adsense code here',
        '13' => 'edit ad',
        '14' => 'ad area:',
        '22' => 'preview ad',
        '23' => 'delete image ',
        '24' => 'delete image'
    ],
    
    
    'pagesedit' => [
        '103' => 'edit post',
        '104' => 'edit post ',
        '105' => 'featured image',
        '106' => 'delete image ',
        '107' => 'chose image'
    ],
    
    
    
    'ordersedit' => [
        '1' => 'order details #',
        '2' => 'delete order',
        '3' => 'general',
        '4' => 'created at : ',
        '5' => 'statue : ',
        '6' => 'bill',
        '7' => 'full name : ',
        '8' => 'company : ',
        '9' => 'adress title 1 : ',
        '10' => 'adress title 2 : ',
        '11' => 'city : ',
        '12' => 'code postal / ZIP : ',
        '13' => 'country : ',
        '14' => 'state : ',
        '15' => 'email : ',
        '16' => 'phone : ',
        '17' => 'notes',
        '18' => 'the buyer didnt add any notes ',
        '19' => 'item',
        '20' => 'التallفة',
        '21' => 'countity',
        '22' => 'total'
    ],
    
    
    'userscreate' => [
        '1' => 'create new user',
        '3' => '* all fields are required , please fill them all',
        '4' => 'create new user',
        '5' => 'username',
        '6' => 'email',
        '7' => 'password',
        '8' => 'role',
        '9' => 'simple user',
        '10' => 'admin',
        '15' => 'create new user'
    ],
    
    
    'socialLinks' => [
        '187' => 'social media links',
        '189' => 'social media',
        '190' => 'please insert the website social media accounts Full link ',
        '191' => 'facebook account',
        '192' => 'twitter account',
        '193' => 'instagram account',
        '194' => 'youtube account',
        '195' => 'edit info'
    ],
    
    
    'SettingsAccount' => [
        '165' => 'edit account ',
        '166' => 'account settings',
        '167' => '* this account is undeletable',
        '168' => 'settings',
        '169' => 'please insert info carefelly',
        '170' => 'username',
        '171' => 'email ',
        '172' => 'edit informations',
        '173' => 'password',
        '174' => 'please chose a good & strong password',
        '175' => 'current password',
        '176' => 'new password',
        '177' => 'repeat new password',
        '178' => 'edit password',
        '179' => 'site admin',
        '180' => 'email',
        '181' => 'created at',
        '182' => 'country',
        '183' => 'logout'
    ],

    
    'faqscreate' => [
        '17' => 'create new faq',
        '19' => 'faq title',
        '20' => 'publish faq',
        '21' => 'faq category',
        '22' => 'not defined'
    ],
    
    'faqsedit ' => [
        '25' => 'edit question',
        '26' => 'edit',
        '27' => 'question title',
        '28' => 'publish faq ',
        '29' => 'faq category',
        '30' => 'not defined'
    ],
    
    'inboxread' => [
        '293' => 'read email',
        '294' => 'print',
        '295' => 'delete',
        '296' => 'by : ',
        '297' => 'subject : ',
    ],

    
 
    
    
    'Email' => [
        '219' => 'email settings',
        '221' => 'host  [SMTP Host] ',
        '222' => 'post  [SMTP Port] ',
        '223' => 'username  [SMTP User] ',
        '224' => 'password [SMTP Password]',
        '225' => 'edit information'
    ],
    
    'bulk_modal' => [
        '1' => 'Alert',
        '2' => 'please ! be aware of next step',
        '3' => 'delete data',
        '4' => 'this action is undone , please take a backup before taking action ',
        '5' => 'please take a backup before taking action',
        '6' => 'i underdtand , please delete all data',
        '7' => 'close '
    ],
    
    
    'Emails' => [
        '219' => 'Great , you inbox is zero ',
        '220' => 'whene you recieve new email , will appear here',
        '221' => 'full name',
        '222' => 'from',
        '223' => 'message',
        '224' => 'sent at'
    ],
    
    
    /******************************************************************************/

     'PostCreatePage' => [
         '21' => 'Article Information',
        '22' => 'Article link',
        '23' => 'Article classification',
        '24' => 'Status',
    ],
    
     'footet_home_page_settings' => [
        '0' => 'costumize home footer',
        '1' => 'footer copyright text',
        '2' => 'copyright text',
        '3' => 'save changes',
        '12' => 'text widgets',
        '13' => 'title',
        '14' => 'widgets content',
        '187' => 'social media links',
        '189' => 'social media',
        '191' => 'facebook link',
        '192' => 'twitter link',
        '193' => 'instagram link',
        '197' => 'pinitrest link',
        '196' => 'viemo link',
        '195' => 'google plus link',
        '194' => 'youtube link',
    ],
    
    'home_pages_block' => [
        '2' => 'First Block',
        '3' => 'The second block',
        '4' => 'The Third Block',
        '5' => 'The Fourth Block',
        '6' => 'The fifth Block',
        '7' => 'the Sixth Block',
        '11' => 'Update information',
        '12' => 'Choose the image ',
        '13' => 'Block title',
        '14' => 'Product categorie',
        '15' => 'home page products blocks',
    ],
    
    'FaqsCategoriesPage' => [
        '0' => 'categories',
        '1' => 'total categories ',
        '2' => 'categorie',
        '3' => 'add new categorie',
        '4' => 'categorie name',
        '5' => 'categorie link',
        '6' => 'add categorie',
        '7' => 'name',
        '8' => 'link',
        '9' => 'total posts',
        '10' => 'edit',
        '11' => 'preview',
        '12' => 'delete',
        '13' => 'save changes',
        '14' => 'total products',
        '15' => 'edit categorie',
    ],   
        

    'SettingsSliderPage' => [
        '1' => 'Slider',
        '2' => 'Upper right picture',
        '3' => 'Picture of the lower right',
        '4' => 'Choose the image',
        '5' => 'Saving changes',
    ],

    'coupons' => [
        '1' => ' ',
        '3' => 'delete all Purchase vouchers',
        '4' => 'Purchasing coupons are a great way to offer rewards and discounts to customers. Will appear here as soon as it is created.',
        '5' => 'Create your first coupon',
    ],
    
    
    'coupons_creat' => [
        '1' => 'create new coupon ',
        '2' => 'coupon code',
        '3' => 'publish coupon',
        '4' => 'رمز القسيمة',
        '5' => 'رمز القسيمة',
         '7' => 'description',
    ],

    'edit' => [
        '342' => 'منح الصلاحيات ',
        '343' => 'منح الصلاحيات',
        '344' => 'تحديد الall ',
        '345' => 'الدخول الى لوحة التحكم',
        '346' => 'تفعيل ',
        '347' => 'الأعضاء',
        '348' => 'انشاء',
        '349' => 'delete',
        '350' => 'تكرار',
        '351' => 'edit',
        '352' => 'delete الall',
        '353' => 'الصفحات',
        '354' => 'انشاء',
        '355' => 'delete',
        '356' => 'تكرار',
        '357' => 'edit',
        '358' => 'delete الall',
        '359' => 'المقالات',
        '360' => 'انشاء',
        '361' => 'delete',
        '362' => 'تكرار',
        '363' => 'edit',
        '364' => 'delete الall',
        '365' => 'products',
        '366' => 'انشاء',
        '367' => 'delete',
        '368' => 'تكرار',
        '369' => 'edit',
        '370' => 'delete الall',
        '371' => 'faq',
        '372' => 'انشاء',
        '373' => 'delete',
        '374' => 'تكرار',
        '375' => 'edit',
        '376' => 'delete الall',
        '377' => 'القوائم',
        '378' => 'انشاء',
        '379' => 'delete',
        '380' => 'edit',
        '381' => 'delete الall',
        '382' => 'الرسائل',
        '383' => 'قراءة',
        '384' => 'delete',
        '385' => 'الوسائط',
        '386' => 'رفع ملف',
        '387' => 'delete',
        '388' => 'delete الall',
        '389' => 'settings',
        '390' => 'التحكم في settings',
        '391' => 'menu البريدية',
        '392' => 'preview ',
        '393' => 'adات',
        '394' => 'انشاء',
        '395' => 'delete',
        '396' => 'edit',
        '397' => 'delete الall',
        '398' => 'حفظ الصلاحيات'
    ],

    

];
