<?php

namespace App\Helpers\Auth;
use App\Models\User;
use App\Classes\Helper;

class Auth {
        
    
    
    
    private $user = false;
    
    public static function User(){
        return $this->user; 
    }
    
    
    public function intialize(){
        
    }
    
    
    
    
    public static function id(){
        
    }
    
    
    
        /**
    * Return the logged in user.
    * @return user array data
    */
    public function getUser(){
        return $this->user;
    }

    
       /**
    * Email the confirmation code function
    * @param string $email User email.
    * @return boolean of success.
    */ 
  private function sendConfirmationEmail($email){
       
  }

     /**
    * Assign a role function
    * @param int $id User id.
    * @param int $role User role.
    * @return boolean of success.
    */
      public function assignRole($id,$role){
     
    }

        /**
    * Check if email is already used function
    * @param string $email User email.
    * @return boolean of success.
    */
    private function checkEmail($email){
       
    }
    
    /**
    * Register a wrong login attemp function
    * @param string $email User email.
    * @return void.
    */
    private function registerWrongLoginAttemp($email){
        $pdo = $this->pdo;
        $stmt = $pdo->prepare('UPDATE users SET wrong_logins = wrong_logins + 1 WHERE email = ?');
        $stmt->execute([$email]);
    }    
    
    /**
    * Logout the user and remove it from the session.
    *
    * @return true
    */
    public static function logout() {
        $_SESSION['user'] = null;
        session_regenerate_id();
        return true;
    }
    
    
    
    public function attempt($email,$password,$type) {
        
        
//        $user = User::where('email','=',$email)->orWhere('username','=',$email)->first();
        
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
    
    
    public function recover($email){
        $user = User::whereEmail($email)->first();
        return !empty($user) ? $user : false;
    }
    
    public function register(){
        
    }
    
    public function username_exists($username){
        $user = User::where('username','=',$username)->first();
        if($user){
            return $user;
        }
        return false;
    }
    
    public function email_exists($email){
        $user = User::where('email','=',$email)->first();
        if($user){
            return $user;
        }
        return false;        
    }
    
    public function avatar_defaults(){
        
        
        



    }
    
    
    
    
    public function validate_username(){
        
    }
    
    
    
    /*
    *   Check if user exist by email
    */
    public function email_user_exist($email){
         $user = User::where('email','=',$email)->first();
         return $user ?? false;   
    }
    
    /*
    *   Check if user exist by email or username
    */
    public function email_or_username_user_exist($email){
         $user = User::where('email','=',$email)->first();
         return $user ?? false;   
    }
    
    
    /*
    *   Send the reset password email 
    */
    public function request_restore_password($email){
        
        // check if the user with that email exist
        $restore = $this->email_or_username_user_exist($email);
        
        
        // if the user exist
        if($restore){
            
            // adding 30 min to the now
            $retrieve_expiration = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"). "+30 minutes"));

            // add Time and Token to Database .
            $recover->retrieve_expiration = $retrieve_expiration;
            $recover->retrieve_token = password_hash($retrieve_expiration,PASSWORD_DEFAULT);
            $recover->save();
                    
            // Send Recover Password Email .
            
        }
        return false;
        
    }
    
    
    
    
    
    
}