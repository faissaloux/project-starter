<?php 

namespace App\Helpers;

defined('BASEPATH') OR exit('No direct script access allowed');

class Helper {
    

    public function meta_redirect($sec,$page){
        echo '<meta http-equiv="refresh" content="'.$sec.'; URL='.$page.'"/>';
    }
    

   
    
    
    public function folderSize ($dir){
        $size = 0;
        foreach (glob(rtrim($dir, '/').'/*', GLOB_NOSORT) as $each) {
            $size += is_file($each) ? filesize($each) : $this->folderSize($each);
        }
        return $size;
    }
    

    
    public function formatBytes($size, $precision = 2) {
        $base = log($size, 1024);
        $suffixes = array('', 'kb', 'mb', 'gb', 'tb');   

        return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
    }


    

    public function format($bytes, $decimals = 2) {
        $exp = 0;
        $value = 0;
        $symbol = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $bytes = (float)$bytes;
        if ($bytes > 0) {
            $exp = floor(log($bytes) / log(1024));
            $value = ($bytes / (1024 ** floor($exp)));
        }
        if ($symbol[$exp] === 'B') {
            $decimals = 0;
        }
        return number_format($value, $decimals, '.', '') . ' ' . $symbol[$exp];
    }
    
    
    
    /*
    *   Format bytes to kilobytes, megabytes, gigabytes
    */
    public static function calc($size, $digits=2){
        $unit= array('','K','M','G','T','P');
        $base= 1024;
        $i = floor(log($size,$base));
        $n = count($unit);
        if($i >= $n){
            $i=$n-1;
        }
        return round($size/pow($base,$i),$digits).' '.$unit[$i] . 'B';
    }
    
    // This function will return the Server Memory Usage:
    public function get_server_memory_usage(){

        $free = shell_exec('free');
        $free = (string)trim($free);
        $free_arr = explode("\n", $free);
        $mem = explode(" ", $free_arr[1]);
        $mem = array_filter($mem);
        $mem = array_merge($mem);
        $memory_usage = $mem[2]/$mem[1]*100;

        return $memory_usage;
    }
    
     // This function will return the Server CPU Usage:
     public function get_server_cpu_usage(){
        $load = \sys_getloadavg();
        return $load[0];
     }
    
    
    
    
 public function getSystemMemInfo()  {       
    $data = explode("\n", file_get_contents("/proc/meminfo"));
    $meminfo = array();
    foreach ($data as $line) {
        list($key, $val) = explode(":", $line);
        $meminfo[$key] = trim($val);
    }
    return $meminfo;
}
    
    
    
    
    public static function is_mobile($mobile) {
        return strlen($mobile) == 11 && preg_match("/^1[3-9]\d{9}$/", $mobile);
    }
    
    
    /*
    *    this function has been tested , it works like a charm
    */
    public function download($file){
        
        if (!file_exists($file)){
            header("Content-type: text/html; charset=utf-8");
            echo "File not found!";
            exit;
        } 
            
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }
    }
    
    public function get_ext($file){
        return substr($file, strrpos($file, '.')+1);
    }
    
 


    
    
    /*
    *  Check Email is Valid
    */
    public function valid_email($email){
        
        // Check if is it a real email
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return false;
        }
        
        // check if is not from banned list
        $file = INC_ROOT.'/app/Libraries/domains.json';
        
        // Check if File Exists
        if(file_exists($file)){
            $bannedEmails = json_decode(file_get_contents());
            if (in_array(strtolower(explode('@', $email)[1]), $bannedEmails)) {
                return false;
            }
        }
        return true;
    }
    
    
    /*
    *  Get User IP
    *  this function is tested & it works perfectly
    */
    public function get_ip_address(){ 
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe

                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
    }
    
    

    
    
    /*
    *    Check if a variable is only numbers and letters
    */
    public function is_alphanumeric ($input){
        if(!preg_match('/^[a-zA-Z]+[a-zA-Z0-9._]+$/', $input)) {
            return true; 
        }else {
            return false;
        }
    }
    
    /*
    *    Check if is a string is small
    */
    public function is_small ($input){
        if(strlen($input)< 3) {
            return false;
        } else {
            return true;
        }
    }   
    
    /*
    *   check a url if it is gravatar
    */
    public function is_gravatar($url){
        if ( false!==stripos($url, 'gravatar') ) {
            return true;
        }
        return false;
    } 
    
    /*
    *    check if a string is an email
    */
    public function is_Email($input){
       if(!filter_var($input, FILTER_VALIDATE_EMAIL)) {
            return true; 
        }else {
            return false;
        }
    }  
    
    
    /*
    *   is unique
    */
    public function is_Unique ($field,$table,$value) {
        $result = $this->container->db->table($table)->where($field, $value)->value($field);
        if($result) {
            return false;
        } else {
            return true;
        }
    }
    
    
    /*
    *   Get time of now  year-month-day Hour:minutes:seconds
    *   Return time
    */
    public function get_Time_Now(){
        $now = new \DateTime();
        return $now->format('Y-m-d H:i:s');
    }
    
    /*
    *   example : contact us page --to--> contact-us-page
    *   remove all whitespace and replace with -
    *   Return srting 
    */
    public function string_To_Uri($string){
      return  preg_replace('/\s+/', '-', $string);
    }
    
    
    /*
    *    Count the words of a string
    */
    public function count_words($word){
        return str_word_count($word);
    }
    
    
    
    

    
    
    /*
    *     Get the current page url
    */
    public function get_page_url(){
      return sprintf(
        "%s://%s%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME'],
        $_SERVER['REQUEST_URI']
      );
    }

  
   public function base_url($atRoot=FALSE, $atCore=FALSE, $parse=FALSE){
        if (isset($_SERVER['HTTP_HOST'])) {
            $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
            $hostname = $_SERVER['HTTP_HOST'];
            $dir =  str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

            $core = preg_split('@/@', str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))), NULL, PREG_SPLIT_NO_EMPTY);
            $core = $core[0];

            $tmplt = $atRoot ? ($atCore ? "%s://%s/%s/" : "%s://%s/") : ($atCore ? "%s://%s/%s/" : "%s://%s%s");
            $end = $atRoot ? ($atCore ? $core : $hostname) : ($atCore ? $core : $dir);
            $base_url = sprintf( $tmplt, $http, $hostname, $end );
        }
        else $base_url = 'http://localhost/';

        if ($parse) {
            $base_url = parse_url($base_url);
            if (isset($base_url['path'])) if ($base_url['path'] == '/') $base_url['path'] = '';
        }

        return $base_url;
    }


    
    /*
    *    Check if a string is empty
    */ 
    public function is_empty($string){
        if(empty($string)){
            return true;
        }else {
            return false;
        }
    }
    
/* return Operating System */

    
  
    
    
    
    
     /*
    *   remove http://, www and slash from URL
    *   example : http://www.google.com/exampleUri  --> google.com 
    */
    public function urlToDomain ($input){
        
        // in case scheme relative URI is passed, e.g., //www.google.com/
        $input = trim($input, '/');

        // If scheme not included, prepend it
        if (!preg_match('#^http(s)?://#', $input)) {
            $input = 'http://' . $input;
        }

        $urlParts = parse_url($input);

        // remove www
        $domain = preg_replace('/^www\./', '', $urlParts['host']);

        return $domain;
    }
    
    
    
    
    
     /*
    *    Get the full Url of the current Page
    */
    public function Get_Full_Url(){
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        return $actual_link;

    }
    
    
    
        

    
    
    /**
     * Mulit-byte Unserialize (http://stackoverflow.com/questions/2853454/php-unserialize-fails-with-non-encoded-characters)
     *
     * UTF-8 will screw up a serialized string
     *
     * @access private
     * @param string
     * @return string
     */
    public function mb_unserialize($string) {
        $string = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $string);
        return unserialize($string);
    }
    
   
    

    
    
    
    
    
    
    
}