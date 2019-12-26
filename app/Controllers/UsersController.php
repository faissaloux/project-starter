<?php

namespace App\Controllers;
use \App\Classes as classes;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Models\User;
use forxer\Gravatar\Gravatar;
use \App\Classes\files;
use Dompdf\Dompdf;
use JasonGrimes\Paginator;


defined('BASEPATH') OR exit('No direct script access allowed');

class UsersController extends Controller{
    
    
        
    
    public $route = [ 'index' => 'users' , 'create' => 'users.create'  ];
    public $model = 'user';
    public $folder = 'users';
    
    public $messages = [
        'created'           => 'coupon code has been created successfully',
        'deleted'           => 'copoun code has been deleted successfully',
        'updated'           => 'copoun code has been updated successfully',
        'bulkDelete'        => 'copouns has been deleted successfully',
        'cloned'            => 'copoun code has been duplicated successfully',   
    ];
    
    
    public function changeUserStatue(){
        
    }

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
    
    
    // Activate the user
    public function activate($request,$response,$args) {
        
        // get the id & the post
        $id = rtrim($args['id'], '/');
        $user = User::find($id);

        // if the user exist delete it & flash success
        if($user) { $user->statue = 1; $user->save(); $this->flashsuccess($this->lang['flash']['97']); }
        
        // redirect to users Home
        return $response->withRedirect($this->router->pathFor('users'));  
    }
    
    
    // Block the user
    public function block($request,$response,$args) {
        
        // get the id & the post
        $id = rtrim($args['id'], '/');
        $user = User::find($id);

        // if the user exist delete it & flash success
        if($user) { $user->statue = 3 ; $user->save(); $this->flashsuccess($this->lang['flash']['98']); }
        
        // redirect to users Home
        return $response->withRedirect($this->router->pathFor('users'));  
    }

    
    public function account($request,$response) {
       return $this->container->view->render($response,'admin/account.twig');
    } 
    
    
//    public function saveData($post){
//        
//    }

    
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
                $user->gender       = $post['gender'];
                $user->birth        = $post['birth'];
                $user->phone        = $post['phone'];
                $user->country      = $post['country'];
                $user->description  = $post['description'];
                $user->facebook     = $post['facebook'];
                $user->twitter      = $post['twitter'];
                $user->youtube      = $post['youtube'];
                $user->save();
                
                // update the session info
                $_SESSION['user-admin'] = $user;
                
                $this->flashsuccess($this->lang['flash']['108']);
                return $route;
                
            }
             
    }
      
    
    public function export_pdf($request,$response) {

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        
        $users = User::All();
        ob_start();
        ?>
        <style>
            table tr td{
                border-bottom: 1px solid black;
                padding: 5px;
            }
        </style>
        <table>
            <tr>
                <th>Userame</th>
                <th>Email</th>
                <th>Created at</th>
            </tr>
            <tbody>
              <tr><td colspan="3"></td></tr>
               <?php foreach($users as $user): ?>
                <tr>
                    <td style="width:250px;"><?php echo $user->username ?></td>
                    <td style="width:250px;"><?php echo $user->email ?></td>
                    <td style="width:250px;"><?php echo $user->created_at ?></td>                    
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <?php
        
        $users = ob_get_clean();

        $dompdf->loadHtml($users);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $filename = date('Y-m-d') . '_users.pdf';
        $dompdf->stream($filename);

    }
   
    public function export_csv($request,$response) {
       
            $stream = fopen('php://memory', 'w+');
            fwrite($stream, chr(0xEF) . chr(0xBB) . chr(0xBF));
            
            // Add header
            $columns = [
                'username','full_name','email','created_at','updated_at','deleted_at',
                'description','phone','facebook','twitter',  'youtube','country', 'ip','gender','birth'
            ];
        
            fputcsv($stream, $columns, ';');
        
            $users = User::All(['username',
                'full_name','email', 'created_at','updated_at','deleted_at','description',
                'phone','facebook','twitter','youtube','country','ip','gender','birth'
            ]);
       
            foreach ($users as $user) {
                  $data = [
                           $user->username,
                            $user->full_name,
                            $user->email,
                            $user->created_at,
                            $user->updated_at,
                            $user->deleted_at,
                            $user->description,
                            $user->phone,
                            $user->facebook,
                            $user->twitter,
                            $user->youtube,
                            $user->country,
                            $user->ip,
                            $user->gender,
                            $user->birth,

                        ];

                fputcsv($stream, $data, ';');
            }
                  
            rewind($stream);
            $filename = date('Y-m-d') . '_users.csv';
            $response = $this->response
                ->withHeader('Content-Type', 'text/csv')
                ->withHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->withHeader('Pragma', 'no-cache')
                ->withHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
                ->withHeader('Expires', '0');

            return $response->withBody(new \Slim\Http\Stream($stream));     
    }  
    
}
