<?php 

namespace App\Helpers;
use Rakit\Validation\Validator as Validation;

defined('BASEPATH') OR exit('No direct script access allowed');

class Validator extends Validation{ 
    
    
    public static function cleanify($post) {
        
        if(is_array($post)){
            
            $clean = [];
            foreach ($post as $key => $value):

            if(is_array($value)) {
               $clean[$key] = self::cleanify($value);
            }else {
                $clean[$key] = self::clean(($value));   
            }
            endforeach;
            
            return $clean;
        }
            
        return self::clean($post);    
    } 
    
    
    public static function clean($data) {
        // Strip HTML Tags
        $clear = strip_tags($data);
        // Clean up things like &amp;
        $clear = html_entity_decode($clear);
        // Strip out any url-encoded stuff
        $clear = urldecode($clear);
        // Replace Multiple spaces with single space
        $clear = preg_replace('/ +/', ' ', $clear);
        // Trim the string of leading/trailing space
        $clear = trim($clear);
        return $clear;
    }
    
    
    public function alphanumeric ($input){
        return !preg_match('/^[a-zA-Z]+[a-zA-Z0-9._]+$/', $input) ? true : false;
    }
    
    public function email($input){
        return !filter_var($input, FILTER_VALIDATE_EMAIL) ? true : false;
    }  
    
    public function url($input){
        return (filter_var($input, FILTER_VALIDATE_URL) === FALSE ) ? false : true ;
    }
    
    public function gravatar($url){
        return ( false!==stripos($url, 'gravatar') ) ? true : false ;
    } 
    
}

