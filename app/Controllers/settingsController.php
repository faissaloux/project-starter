<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Helpers\Email\Email;
use \App\Models\options;
use \App\Models\User;
use \App\Models\ProductCategories;
use \App\Helpers\Classes\app;
use \App\Helpers\Classes\files;
use \App\Helpers\Classes\SystemInfo;
use \App\Helpers\Classes\TimeZone\TimeZoneSelect;

defined('BASEPATH') OR exit('No direct script access allowed');

class settingsController extends Controller {
    
        
    public $route = [ 'index' => 'coupons' , 'create' => 'coupons.create'  ];
    public $model = 'user';
    public $folder = 'coupons';
    
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
    
    
    
    public function account($request,$response){
        
        if(isset($_SESSION['auth-admin'])) {
         
        $user = User::find($_SESSION['auth-admin']);
        
        if($request->getMethod() == 'GET'){
            return $this->view->render($response,'admin/settings/account.twig', ['user'=>$user]);
        }
        
        if($request->getMethod() == 'POST'){
            
            $form   = $request->getParam('validate');
            $post   = $request->getParams();
            $helper = $this->helper;
            $route = $response->withRedirect($this->router->pathFor('settings.account', ['user'=>$user ]));
            
            
            if($form == 'validate_my_settings'){
              
                // Get the post & clean 
                $username = $helper->clean($post['username']);
                $email    = $helper->clean($post['email']);
                
                // check if the username is empty
                
                if($helper->is_empty($username)){$this->flasherror($this->lang['flash']['76']);return $route;}
                
                // check if the username is alphanumeric
                if($helper->is_alphanumeric($username)){ $this->flasherror($this->lang['flash']['77']); return $route;} 
                
                // check if the email is empty
                if($helper->is_empty($email)){ $this->flasherror($this->lang['flash']['78']);return $route;}
                
                // check if the email is valid
                if(!$helper->valid_email($email)){ $this->flasherror($this->lang['flash']['79']); return $route;}
                
                // if every thing is good save !
                $user->username = $username;
                $user->email = $email;
                $user->save();
                
                // success & redirect
                $this->flashsuccess($this->lang['flash']['80']); 
                return $route;
                
            }
            
            if($form == 'validate_my_pass'){
               
                // Get the post & clean 
                $old_pass    = $helper->clean($post['old_pass']);
                $new_pass    = $helper->clean($post['new_pass']);
                $new_pass_re = $helper->clean($post['new_pass_re']);
                
                // check if the password is correct
                if(!password_verify($old_pass,$user->password)) {
                  $this->flasherror($this->lang['flash']['81']);
                  return $route;
                }
                
                // check if the new passwords are not empty
                if(empty($new_pass) or empty($new_pass_re)){
                  $this->flasherror($this->lang['flash']['82']);
                  return $route;
                }
                
                // check if the new password is correct
                if($new_pass != $new_pass_re){
                  $this->flasherror($this->lang['flash']['83']);
                  return $route;
                }
                
                // hash the new password & and add it to database & save
                $password = password_hash($new_pass,PASSWORD_DEFAULT);    
                $user->password = $password;
                $user->save();
                
                // success & redirect
                $this->flashsuccess($this->lang['flash']['84']);
                return $route;
            }
            
            
        }
        
        }
        
    }
    
    
    public function index($request,$response) {
        
        if($request->getMethod() == 'POST'){

        echo '<pre>';
        $request->getParams();
        exit;
        
       }
        /*
       *    تحميل نسخة من قاعدة البيانات
       */
        $download = $request->getParam('export');
        if(isset($download)){
            include_once dirname(__DIR__).'/Classes/database_exporter.php';
            $world_dumper = \Shuttle_Dumper::create(array(
                'host' => $this->conf['db.host'],
                'username' => $this->conf['db.username'],
                'password' => $this->conf['db.password'],
                'db_name' => $this->conf['db.name'],
            ));

            $file_url = 'database.sql';
            header('Content-Type: application/octet-stream');
            header("Content-Transfer-Encoding: Binary"); 
            header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\""); 
            readfile($file_url); // do the double-download-dance (dirty but worky)
            unlink($file_url);
            
       }
       return $this->view->render($response,'admin/settings/index.twig');
    } 

    
   
    
    
    public function general($request,$response) {
       
 
        $post   = validator::cleanify($request->getParams());
        $up     = $this->files;
        $path = $this->dir('general');
        $options = new options();
        $logo    = $_FILES['logo'];
        $favicon = $_FILES['favicon'];
        
        if( $post['logochanged'] == 'true' and isset($logo['name']) )  { 
            
            // Delete the Old logo file
            $oldLogo = $this->dir('general').$options->get_option('logo');
            
            if(file_exists($oldLogo)){
                unlink($oldLogo);
            }
            
            $options->update_option('logo', $up->up($path,$logo)) ; 
        } 
        
        if( $post['faviconchanged'] == 'true' and isset($favicon['name']) )  { 
           
            $options->update_option('favicon', $up->up($path,$favicon)) ; 
        } 
        
        $settings = ['name','description','keywords','mode','phone','email','adress','ganalitycs'];
        foreach( $settings as $item ) {  $options->update_option($item, $post[$item]);   }

        $this->flashsuccess($this->lang['flash']['85']);
        return $response->withRedirect($this->router->pathFor('settings', compact('options')));

    }  
    
    public function home($request,$response){
        
        if($request->getMethod() == 'GET'){
            $categories     = ProductCategories::All();
            return $this->view->render($response,'admin/settings/home.twig', ['categories'=>$categories]);
        }
        
        if($request->getMethod() == 'POST'){
            $uploader = new files();
            $options = new options();    
            
            
            if(isset($_FILES) and !empty($_FILES)) {
              for($x=0;$x<7;$x++):
                  if(isset($_FILES["BLOCK_IMAGE_".$x]) and !empty($_FILES["BLOCK_IMAGE_".$x]['name'])) {  
                    $image =  $uploader->upload_avatar($this->container->conf['dir.general'],$_FILES["BLOCK_IMAGE_".$x]);
                    $options->update_option("BLOCK_IMAGE_".$x,$image);
                  }
             endfor;
            }
    
            foreach($request->getParams() as $key => $value):
            $options->update_option($key,$value);
            endforeach;
            $this->flash->addMessage('success',$this->lang['flash']['85']);
            return $response->withRedirect($this->router->pathFor('settings.home', ['options'=>$options ]));
        }
        
       
        
    }
    
    public function slider($request,$response){
        
        if($request->getMethod() == 'GET'){
            return $this->view->render($response,'admin/settings/slider.twig');
        }
        
        
       if($request->getMethod() == 'POST'){

            $files = new files();
           
            if(isset($_FILES['slidertopright']) and !empty($_FILES['slidertopright']['name'])) {
                $uploader = new files();
                $slider1 =   $uploader->upload_avatar($this->container->conf['dir.slider'],$_FILES['slidertopright']);
                Options::update_option('HOME_SLIDER_RIGHT_TOP',$slider1);
            }

            if(isset($_FILES['sliderbottomright']) and !empty($_FILES['sliderbottomright']['name'])) {
                $uploader = new files();
                $slider2 =   $uploader->upload_avatar($this->container->conf['dir.slider'],$_FILES['sliderbottomright']);
                Options::update_option('HOME_SLIDER_RIGHT_BOTTOM',$slider2);
            }
        
            $this->flash->addMessage('success',$this->lang['flash']['85']);
            return $response->withRedirect($this->router->pathFor('beside-slider', ['options'=>$options ]));
         }
        
    }
    
    public function footer($request,$response){
        
        if($request->getMethod() == 'GET'){
            return $this->view->render($response,'admin/settings/footer.twig');
        }
        
        
       if($request->getMethod() == 'POST'){

           $files = new files();
           $options = new options();

           $options->update_option('footer_text_widget_title_1',$request->getParam('footer_text_widget_title_1'));
           $options->update_option('footer_text_widget_content_1',$request->getParam('footer_text_widget_content_1'));
           $options->update_option('footer_text_widget_title_2',$request->getParam('footer_text_widget_title_2'));
           $options->update_option('footer_text_widget_content_2',$request->getParam('footer_text_widget_content_2'));
           $options->update_option('footer_text_widget_title_3',$request->getParam('footer_text_widget_title_3'));
           $options->update_option('footer_text_widget_content_3',$request->getParam('footer_text_widget_content_3'));
           $options->update_option('footer_text_widget_title_4',$request->getParam('footer_text_widget_title_4'));
           $options->update_option('footer_text_widget_content_4',$request->getParam('footer_text_widget_content_4'));
           $options->update_option('footer_text_widget_title_5',$request->getParam('footer_text_widget_title_5'));
           $options->update_option('footer_text_widget_content_5',$request->getParam('footer_text_widget_content_5'));
           $options->update_option('footer_link_fb',$request->getParam('footer_link_fb'));
           $options->update_option('footer_link_tw',$request->getParam('footer_link_tw'));
           $options->update_option('footer_link_yb',$request->getParam('footer_link_yb'));
           $options->update_option('footer_link_pi',$request->getParam('footer_link_pi'));
           $options->update_option('footer_link_ins',$request->getParam('footer_link_ins'));
           $options->update_option('footer_link_vie',$request->getParam('footer_link_vie'));
           $options->update_option('footer_link_gp',$request->getParam('footer_link_gp'));
           $options->update_option('footer_copyrights',$request->getParam('footer_copyrights'));
           

            $this->flash->addMessage('success',$this->lang['flash']['85']);
            return $response->withRedirect($this->router->pathFor('settings.footer'));
         }
        
    }
    
    
    
    public function others($request,$response){
        
        if($request->getMethod() == 'GET'){
            return $this->view->render($response,'admin/settings/others.twig');
        }
        
        
       if($request->getMethod() == 'POST'){

               $options = new options();
               foreach($request->getParams() as $key => $value) {
                    $options->update_option($key,$value);               
               }
            $this->flash->addMessage('success',$this->lang['flash']['85']);
            return $response->withRedirect($this->router->pathFor('settings.others'));
         }
        
    }
    
    
    
    public function store($request,$response,$args){
        
        if($request->getMethod() == 'GET'){
            
            
        

            return $this->view->render($response,'admin/settings/store.twig',
        ['listTimeZone'=> TimeZoneSelect::get_select_html([
            'country'=>'US',
            'name'           => 'time_zone',
    'class'          => 'form-control',  
            'selected'=>'Pacific/Midway'
        ])]);
        }
        
        if($request->getMethod() == 'POST'){
       
        }
        
       
        
    }
     
    
    public function payments($request,$response){
        
        if($request->getMethod() == 'GET'){
            
            
        

            return $this->view->render($response,'admin/settings/payments.twig',
        ['listTimeZone'=> TimeZoneSelect::get_select_html([
            'country'=>'US',
            'name'           => 'time_zone',
    'class'          => 'form-control',  
            'selected'=>'Pacific/Midway'
        ])]);
        }
        
        if($request->getMethod() == 'POST'){
       
        }
        
       
        
    }
    
    
    
    
    
    
    public function paypal($request,$response){
        
        if($request->getMethod() == 'GET'){
            return $this->view->render($response,'admin/settings/payments/paypal.twig');
        }
        
        if($request->getMethod() == 'POST'){
       
        }
    }
    
    
    
    
    public function stripe($request,$response){
        
        if($request->getMethod() == 'GET'){
            return $this->view->render($response,'admin/settings/payments/stripe.twig');
        }
        
        if($request->getMethod() == 'POST'){
       
        }
    }
    
    

    
    
    
    public function system($request,$response){
        
       
        if($request->getMethod() == 'GET'){
            
            $system = new SystemInfo();
           
            $info = [
                'freeSpaece' =>  $system->getFreeDiskSpace(),
                'phpv' => $system->GetPHPversion(),
                'curlv' => $system->curl_version(),
                'mysqlv' => $system->GetMysqlVersion(),
                'phpmemorylimit' => $system->getMemoryLimit(),
                'phptimelimit' => $system->getMaxExecutionTime(),
                'phppostmax' => $system->post_max_size(),
                'phpmaxupload' => $system->upload_max_filesize(),
                'phpdatabasesize' => $system->GetDatabaseSize(),
                'phpfilessize' => $system->FilesSize(),
                'zipext' => $system->isZipLoaded(),
                'phpmaxinputvars' => $system->MaxInputVars(),
                'server-ip' => $system->GetserverIp(),
            ];
                
            return $this->view->render($response,'admin/settings/system.twig',compact('info'));
        }
     
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
    }
    
    
}

