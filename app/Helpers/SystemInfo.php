<?php 

namespace App\Helpers\Classes;
use \App\Helpers\Classes\Helper;
use Illuminate\Database\Capsule\Manager as Capsule;


defined('BASEPATH') OR exit('No direct script access allowed');

class SystemInfo {
    
    protected $helper;
    
    public function __construct(){
        $this->helper = new Helper();
    }
    
    
    function getOSInformation() {
       return php_uname('s');
    }
    
    
    public function GetserverIp(){
        return $_SERVER['SERVER_ADDR'];
    }
    
    public function GetTimeLimit(){
        return ini_get("max_execution_time");
    }
       
    public function GetPHPversion(){
        return phpversion();
    }
    
    public function FilesSize(){
        return $this->helper->formatBytes($this->helper->foldersize(BASEPATH.'/'));
    }
    
       
    public function curl_version(){
        return curl_version()["version"];   
    }
    
    public function isSecure(){
        return ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443 ) ? 'yes' : 'No';
    }
    
   
    public function getMaxExecutionTime(){
        return ini_get('max_execution_time');
    }
    
    public function getMemoryLimit(){
        return ini_get('memory_limit');
    }
    
    public function upload_max_filesize (){
      return  ini_get('upload_max_filesize');
    }
	
    
    public function MaxInputVars (){
      return  ini_get('max_input_time');
    }    
    
    
    function is_openSSL() {
        return ini_get('post_max_size');
    }

    public function getFreeDiskSpace (){
        
      return  $this->helper->formatBytes(@disk_free_space(SCRIPTDIR));
    }
    
    
    function post_max_size() {
        return ini_get('post_max_size');
    }

    public function GetDatabaseSize(){
        
      $capsule = new Capsule;
      $capsule->addConnection([
            'driver'    => $container['conf']['db.driver'],
            'host'      => $container['conf']['db.host'],
            'database'  => $container['conf']['db.name'],
            'username'  => $container['conf']['db.username'],
            'password'  => $container['conf']['db.password'],
            'charset'   => $container['conf']['db.charset'],
            'collation' => $container['conf']['db.collation'],
            'prefix'    => '',
            'strict' => false
        ]);
        
        $pdo = $capsule->connection()->getPdo();
      
        
        
         
        // get the size of database
        $size = 0;
        foreach($pdo->query('SHOW TABLE STATUS')->fetchAll() as $row) {
            $size += $row["Data_length"] + $row["Index_length"];  
        }
        // change from bytes to megabytes
        $decimals = 2;  
        $databasesize = number_format($size/(1024*1024),$decimals);
        
        return $databasesize .' mb';
        
    }
    
    public function GetMysqlVersion(){
        
      $capsule = new Capsule;
      $capsule->addConnection([
            'driver'    => $container['conf']['db.driver'],
            'host'      => $container['conf']['db.host'],
            'database'  => $container['conf']['db.name'],
            'username'  => $container['conf']['db.username'],
            'password'  => $container['conf']['db.password'],
            'charset'   => $container['conf']['db.charset'],
            'collation' => $container['conf']['db.collation'],
            'prefix'    => '',
            'strict' => false
        ]);
        
        $pdo = $capsule->connection()->getPdo();
      
        return $pdo->query('select version()')->fetchColumn();
    }

     
    public function isZipLoaded(){
        return extension_loaded("zip") ? true : false;
    }
     
    
}