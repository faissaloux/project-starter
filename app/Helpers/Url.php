<?php 

namespace App\Core\dist;

defined('BASEPATH') OR exit('No direct script access allowed');

class Url {
        
    
    /**
     * Go to the previous url.
     */
    public static function previous() {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
    
   public static function redirect($url = null, $fullpath = false) {
        if ($fullpath == false) {
            $url = APPLICATION['BASE_PATH'] . '/' . $url;
        }

        header('Location: ' . $url);
        exit();
    }
    
    
    /**
     * This function converts and url segment to an safe one, for example:
     * `test name @132` will be converted to `test-name--123`
     * Basicly it works by replacing every character that isn't an letter or an number to an dash sign
     * It will also return all letters in lowercase.
     *
     * @param $slug -
     *        	The url slug to convert
     *
     * @return mixed|string
     */
    public static function generateSafeSlug($slug) {
        setlocale(LC_ALL, "en_US.utf8");

        $slug = preg_replace('/[`^~\'"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $slug));

        $slug = htmlentities($slug, ENT_QUOTES, 'UTF-8');

        $pattern = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
        $slug = preg_replace($pattern, '$1', $slug);

        $slug = html_entity_decode($slug, ENT_QUOTES, 'UTF-8');

        $pattern = '~[^0-9a-z]+~i';
        $slug = preg_replace($pattern, '-', $slug);

        return strtolower(trim($slug, '-'));
    }
    
}