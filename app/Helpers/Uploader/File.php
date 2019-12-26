<?php

namespace App\Helpers\Helpers\Files;
use \App\Helpers\Classes\Helper;
use \App\Helpers\Helpers\Files\uploader as st_uploder;


/**
 * Collection of methods for working with documents.
 */
class File {

    public $file;
    
    public $path;
    
    public $name;
    
    public $type;
    
    private $helper;
    
    public function __construct() {
        $this->fileName = 'unnamed_attachment';
		$this->fileContent = '';
        $this->helper = new helper();
    
    }
  
    public function up(){
        $handle = new st_uploder($this->file);
        if ($handle->uploaded) {
            
        $nameimmg = $this->helper->str_random();
        
       
        
        $handle->file_new_name_body   = $nameimmg;

        $handle->process($this->path);
          if ($handle->processed) {
                $uploaded = $nameimmg.'.'.$handle->file_src_name_ext;
                $handle->clean();
                $this->name = $uploaded;
                $this->type = self::getFileType(self::getExtension($uploaded));
                return true;
          } else {
            return false;
          }
        }
    }
    
    
	/**
	 * group types into collections, its purpose is to assign the passed extension to the suitable group
	 *
	 * @param string $extension
	 *        	file extension
	 *        	
	 * @return string group name
	 */
	public static function getFileType($extension) {
		$images = array ('jpg','gif','png','bmp');
		$docs = array ('txt','rtf','doc','docx','pdf');
		$apps = array ('zip','rar','exe','html');
		$video = array ('mpg','wmv','avi','mp4');
		$audio = array ('wav','mp3');
		$db = array ('sql','csv','xls','xlsx');
		
		if (in_array($extension, $images)) {
			return "Image";
		}
		if (in_array($extension, $docs)) {
			return "Document";
		}
		if (in_array($extension, $apps)) {
			return "Application";
		}
		if (in_array($extension, $video)) {
			return "Video";
		}
		if (in_array($extension, $audio)) {
			return "Audio";
		}
		if (in_array($extension, $db)) {
			return "Database/Spreadsheet";
		}
		return "Other";
	}

	/**
	 * Create a human friendly measure of the size provided.
	 *
	 * @param integer $bytes
	 *        	file size
	 * @param integer $precision
	 *        	precision to be used
	 *        	
	 * @return string size with measure
	 */
	public static function formatBytes($bytes, $precision = 2) {
		$units = array ('B','KB','MB','GB','TB');
		
		$bytes = max($bytes, 0);
		$pow = floor(($bytes ? log($bytes) : 0) / log(1024));
		$pow = min($pow, count($units) - 1);
		
		$bytes /= pow(1024, $pow);
		
		return round($bytes, $precision) . ' ' . $units[$pow];
	}

	/**
	 * Converts a human readable file size value to a number of bytes that it
	 * represents.
	 * Supports the following modifiers: K, M, G and T.
	 * Invalid input is returned unchanged.
	 *
	 * Example:
	 * <code>
	 * $config->getBytesSize(10); // 10
	 * $config->getBytesSize('10b'); // 10
	 * $config->getBytesSize('10k'); // 10240
	 * $config->getBytesSize('10K'); // 10240
	 * $config->getBytesSize('10kb'); // 10240
	 * $config->getBytesSize('10Kb'); // 10240
	 * // and even
	 * $config->getBytesSize(' 10 KB '); // 10240
	 * </code>
	 *
	 * @param number|string $value        	
	 *
	 * @return number
	 */
	public static function getBytesSize($value) {
		return preg_replace_callback('/^\s*(\d+)\s*(?:([kmgt]?)b?)?\s*$/i', function ($m) {
			switch (strtolower($m[2])) {
				case 't' :
					$m[1] *= 1024;
					break;
				case 'g' :
					$m[1] *= 1024;
					break;
				case 'm' :
					$m[1] *= 1024;
					break;
				case 'k' :
					$m[1] *= 1024;
					break;
			}
			return $m[1];
		}, $value);
	}

	/**
	 * Return the bytes file of a folder.
	 *
	 * @param string $path        	
	 *
	 * @return string
	 */
	public static function getFolderSize($path) {
		$io = popen('/usr/bin/du -sb ' . $path, 'r');
		$size = intval(fgets($io, 80));
		pclose($io);
		return $size;
	}

	/**
	 * Return the file type based on the filename provided.
	 *
	 * @param string $file        	
	 *
	 * @return string
	 */
	public static function getExtension($file) {
		return pathinfo($file, PATHINFO_EXTENSION);
	}

	/**
	 * Remove extension of file.
	 *
	 * @param string $file
	 *        	filename and extension
	 *        	
	 * @return file name missing extension
	 */
	public static function removeExtension($file) {
		if (strpos($file, '.')) {
			$file = pathinfo($file, PATHINFO_FILENAME);
		}
		return $file;
	}

	protected $fileName;

	protected $fileContent;

	

	public function setFileName($fileName) {
		$this->fileName = $fileName;
	}

	public function setFileContent($fileContent) {
		$this->fileContent = $fileContent;
	}

	public function setContentType($contentType) {
		$this->contentType = $contentType;
	}

	public function readFileContent($fileNameToRead) {
		$this->fileContent = file_get_contents($fileNameToRead);
	}

	public function startDownload() {
		/* if no filename is set, set content type to octet stream */
		if ($this->fileName == 'unnamed_attachment')
			$this->contentType = mime_content_type($this->fileName);
		else
			$this->contentType = 'application/octet-stream';
			
			/* check if it is SSL connection */
		if ($_SERVER["HTTPS"] != '')
			$this->startSSLDownload();
		else {
			header('Content-type: ' . $this->contentType);
			header("Content-Disposition: attachment; filename=" . $this->fileName . ";");
			echo $this->fileContent;
			exit();
		}
	}

	public function startSSLDownload() {
		header("Cache-Control: maxage=1");
		header("Pragma: public");
		header('Content-type: ' . $this->contentType);
		header("Content-Disposition: attachment; filename=" . $this->fileName . ";");
		echo $this->fileContent;
		exit();
	}
}