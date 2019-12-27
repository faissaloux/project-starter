<?php

namespace App\Helpers\Auth;
use App\Models\User;
use App\Classes\Helper;

class Auth {
        
    
    
    
    private $user = false;
    
    public static function User(){
        return $this->user; 
    }
    
    public function getUser(){
        return $this->user;
    }

  
    public static function logout() {
        $_SESSION['user'] = null;
        session_regenerate_id();
        return true;
    }
    
    
    
    public function attempt($email,$password,$type) {
                
        $user = User::whereEmail($email)->orWhere('username','=',$email)->first();
        
        if($type == 'user'){
            

            if(password_verify($password,$user->password)) {
				
				
				if($user->statue == 3) {
                    return false;
                }
				
				
                    session_start();
                    $_SESSION['auth-user'] = $user->id;
                    return true;
            } 
        }
        if($type == 'admin'){
     
            if($user){
                if($user->role != '2' and $user->statue != '3') {
                    return false;
                }
                if(password_verify($password,$user->password)) {
                    $_SESSION['auth-admin'] = $user->id;
                    return true;
                } 
            }
        }
        
        return false;
    }
    
    

    
    
    
    
}