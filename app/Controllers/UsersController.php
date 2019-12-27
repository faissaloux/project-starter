<?php

namespace App\Controllers;
use \App\Classes as classes;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\User;
use \App\Classes\files;
use JasonGrimes\Paginator;


defined('BASEPATH') OR exit('No direct script access allowed');

class UsersController extends Controller{
    
    
        
    
    public $route = [ 'index' => 'users' , 'create' => 'users.create'  ];
    public $model = 'user';
    public $folder = 'users';
    
   
    // Delete the user
    public function delete($request,$response,$args) {
        
        // get the id & the post
        $id = rtrim($args['id'], '/');
        $user = User::find($id);
        if($user) {
            
         if($user->statue == 'supper') {
                    $this->flasherror($this->lang['flash']['95']);
                    return $response->withHeader('Location', $this->router->urlFor('users'));
                }
            else{
                    // get the avatar
                    $thumbnail = $this->dir('avatars').$user->avatar;
             
                     // if the thumbnail exist delete it
                    if(file_exists($thumbnail)){unlink($thumbnail);}
             
             
                    $user->delete();
                    $this->flashsuccess($this->lang['flash']['96']);
                    return $response->withHeader('Location', $this->router->urlFor('users'));
            }       
        }
        
        // redirect to users Home
        return $response->withRedirect($this->router->pathFor('users'));  
    }
    
   
    
    public function account($request,$response) {
       return $this->container->view->render($response,'admin/account.twig');
    } 
    


    
    public function store($request,$response,$args){
  
        
        // get the form & set rules
        $validation = $this->validator->make($_POST, [
            'username'              => 'required|min:4|alpha_num',
            'email'                 => 'required|email',
            'password'              => 'required|min:4',
        ]);
        
        // set messages
        $validation->setMessages([
                    'username:required'     => 'المرجوا ادخال اسم المستخدم',
                    'username:min'          => 'اسم المستخدم صغير جداً',
                    'username:alpha_num'    => 'اسم المستخدم يجب ان يتكون من حروف وأرقام فقط',
                    'email:required'        => 'المرجوا ادخال البريد الإلكتروني',
                    'email:email'           => 'البريد الإلكتروني غير صحيح',
                    'password:required'     => 'المرجوا ادخال كلمة المرور',
                    'password:min'          => 'كلمة المرور صغيرة جداً ',
        ]);
        
        // then validate
        $validation->validate();
        
        
        
       
        
        if ($validation->fails()) {
                        
//            sv();
            

            $this->flasherror($validation->errors()->firstOfAll());
            $route = $response->withRedirect($this->router->pathFor('users.create'));
            return $route;
      
        } else {
            // validation passes
            echo "Success!";
        }

        
        
        if($request->getMethod() == 'POST'){  

                // Get the parameters Sent by the Form & initialize the helper 
            
                $post = validator::cleanify($request->getParams());
                
                // the route to redirect for errors
                $route = $response->withRedirect($this->router->pathFor('users.create'));

                // Clean the variables & set the username & email to lowercase
                $username   = strtolower($post['username']);
                $email      = strtolower($post['email']);
               
                // check if username is not empty
                if($helper->is_empty($username)){ $this->flasherror($this->lang['flash']['99']);return $route; }
                 
                // check if the email is not empty
                if($helper->is_empty($email)){ $this->flasherror($this->lang['flash']['100']); return $route; } 
                 
                // check if the password is empty
                if($helper->is_empty($post['password'])){ $this->flasherror($this->lang['flash']['101']);return $route; }
                 
                // check if the username is only numbers and letters
                if($helper->is_alphanumeric($username)){ $this->flasherror($this->lang['flash']['102']); return $route;} 
                 
                // check if the username already exist
                if(!empty(User::where('username',$username)->first())){ $this->flasherror( $this->lang['flash']['103']);return $route; }
                                  
                // check if the email is a real email & a valid email
                if(!$helper->valid_email($email)){ $this->flasherror($this->lang['flash']['104']); return $route;}
                 
                // check if the email is already used 
                if(!empty(User::where('email',$email)->first())){ $this->flasherror($this->lang['flash']['105']); return $route;}

                // generate the avatar
                $avatar = Gravatar::image($email) ? Gravatar::image($email) :  'default-avatar.png';
                    

             $user = new User();
             $user->username = $username;
             $user->email = $email;
             $user->password = password_hash($post['password'],PASSWORD_DEFAULT);
             $user->role = $username;
             $user->avatar = $avatar;
             $user->statue = 1;
             $user->save();
      
    
              
                
                // try to add this email to attempt class
                if($user) {
                    $this->Emailer->to = $email;
                    $this->Emailer->username = $username;
                    $this->Emailer->Registration_email; 
                    $this->flashsuccess($this->lang['flash']['109']);
                    return $response->withRedirect($this->router->pathFor('users'));
                }else{
                   $this->flasherror($this->lang['flash']['107']);
                    return $route;
                }
             
                
        }
    }

    
    public function update($request,$response,$args){
                    
            // Get the parameters Sent by the Form & initialize the helper & the fileupldader
            $post = validator::cleanify($request->getParams());
            $up  =  $this->files;
            
            $route = $response->withRedirect($this->router->pathFor('users.edit', ['username'=> $user->username , 'user'=>$user]));
                 
            $avatarimg = $_FILES['avatar'];        
                    
            // edit user info
            if($request->getParam('validate') == 'update-general-user-info'){
                
                // Upload the Avatar & update it in database and delete the old 
                
                // check first of all if avatar is changed !
                if($post['avatarChanged'] == 'true') {
                    
                    // check if there is a file
                    if(isset($avatarimg) and !empty($avatarimg['name'])) {

                        // Upload
                        $avatar =  $up->up($this->dir('avatars'),$avatarimg);

                        // check if the user avatar is not gravatar , if is not , Delete Previews avatar file
                        if(!$validator->is_gravatar($user->avatar)){
                             $avatar_path = $this->dir('avatars').'/'.$user->avatar;
                             if (file_exists($avatar_path)) {
                                unlink($avatar_path);
                             }
                        }     

                        // update it in database with the new one
                        $user->avatar  =  $avatar;
                    }
                }
               
                
                // update the user info
                $user->password = !empty($post['password']) ? password_hash($post['password'],PASSWORD_DEFAULT) : $user->password;
                $user->username     = strtolower($post['username']);;
                $user->full_name    = strtolower($post['full_name']);
                $user->email        = strtolower($post['email']);
                $user->birth        = $post['birth'];
                $user->phone        = $post['phone'];
                $user->country      = $post['country'];
                $user->description  = $post['description'];

                $user->save();
                
                // update the session info
                $_SESSION['user-admin'] = $user;
                
                $this->flashsuccess($this->lang['flash']['108']);
                return $route;
                
            }
             
    }
      

}
