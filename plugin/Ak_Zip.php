<?php
class Ak_Zip
{
	/**
	 * zip out file
	 *
	 * @var string
	 */
	private $_OutFile = 'Ak_Zip.zip';
	
	
	/**
	 * send in, maybe files or folder
	 *
	 * @var
	 */
    private $_InFF;
	
	/**
	 * the type of send in
	 * maybe:file, folder
	 *
	 * @var
	 */
    private $_InType;
	
	/**
	 * the object of class ZipArchive 
	 *
	 * @var object
	 */
    private $_ZipObj;
	
	/**
	 * error info
	 *
	 * @var array
	 */
	public $_Error = array();
	
	function __construct($inFF, $ourFile = '') {
		$this->_InFF = $inFF;
		if ($ourFile != '') {
			$this->_OutFile = str_replace('\\', '/', $ourFile);
		}
		if (file_exists($this->_OutFile)) {
			$this->setError('Out put file is exist.');
		}
		
		$this->_ZipObj = new ZipArchive();
		
		$this->setInType();
	}

    /**
     * Add files and sub-directories in a folder to zip file.
     * @param string $folder
     * @param ZipArchive $zipFile
     * @param int $exclusiveLength Number of text to be exclusived from the file path.
     */
    private static function folderToZip($folder, &$zipFile, $exclusiveLength) {
        $handle = opendir($folder);
        while (false !== $f = readdir($handle)) {
            if ($f != '.' && $f != '..') {
                $filePath = "$folder/$f";
                // Remove prefix from file path before add to zip.
                $localPath = substr($filePath, $exclusiveLength);
                if (is_file($filePath)) {
                    $zipFile->addFile($filePath, $localPath);
                } elseif (is_dir($filePath)) {
                    // Add sub-directory.
                    $zipFile->addEmptyDir($localPath);
                    self::folderToZip($filePath, $zipFile, $exclusiveLength);
                }
            }
        }
        closedir($handle);
    }

    /**
     * Zip a folder (include itself).
     * Usage:
     *   HZip::zipDir('/path/to/sourceDir', '/path/to/out.zip');
     *
     * @param string $sourcePath Path of directory to be zip.
     * @param string $outZipPath Path of output zip file.
     */
    public static function zipDir($sourcePath, $outZipPath)
    {
        $pathInfo = pathInfo($sourcePath);
        $parentPath = $pathInfo['dirname'];
        $dirName = $pathInfo['basename'];

        $z = new ZipArchive();
        $z->open($outZipPath, ZIPARCHIVE::CREATE);
        $z->addEmptyDir($dirName);
        self::folderToZip($sourcePath, $z, strlen("$parentPath/"));
        $z->close();
    }

    function ZipStatusString( $status )
    {
        switch( (int) $status )
        {
            case ZipArchive::ER_OK           : return 'N No error';
            case ZipArchive::ER_MULTIDISK    : return 'N Multi-disk zip archives not supported';
            case ZipArchive::ER_RENAME       : return 'S Renaming temporary file failed';
            case ZipArchive::ER_CLOSE        : return 'S Closing zip archive failed';
            case ZipArchive::ER_SEEK         : return 'S Seek error';
            case ZipArchive::ER_READ         : return 'S Read error';
            case ZipArchive::ER_WRITE        : return 'S Write error';
            case ZipArchive::ER_CRC          : return 'N CRC error';
            case ZipArchive::ER_ZIPCLOSED    : return 'N Containing zip archive was closed';
            case ZipArchive::ER_NOENT        : return 'N No such file';
            case ZipArchive::ER_EXISTS       : return 'N File already exists';
            case ZipArchive::ER_OPEN         : return 'S Can\'t open file';
            case ZipArchive::ER_TMPOPEN      : return 'S Failure to create temporary file';
            case ZipArchive::ER_ZLIB         : return 'Z Zlib error';
            case ZipArchive::ER_MEMORY       : return 'N Malloc failure';
            case ZipArchive::ER_CHANGED      : return 'N Entry has been changed';
            case ZipArchive::ER_COMPNOTSUPP  : return 'N Compression method not supported';
            case ZipArchive::ER_EOF          : return 'N Premature EOF';
            case ZipArchive::ER_INVAL        : return 'N Invalid argument';
            case ZipArchive::ER_NOZIP        : return 'N Not a zip archive';
            case ZipArchive::ER_INTERNAL     : return 'N Internal error';
            case ZipArchive::ER_INCONS       : return 'N Zip archive inconsistent';
            case ZipArchive::ER_REMOVE       : return 'S Can\'t remove file';
            case ZipArchive::ER_DELETED      : return 'N Entry has been deleted';

            default: return sprintf('Unknown status %s', $status );
        }
    }

    function checkOutFile() {
		if(strtolower(end(explode('.',$filename))) != 'zip'){
			return false;
		}
		
		return true;
	}
	function setError($msg) {
		$this->_Error[] = $msg;
	}
	
	function zip() {
		switch ($this->_InType) {
			case 'folder':
				$ret = $this->folderZip();
				if (!$ret) {
					$this->setError('zip folder error.');
				}
				break;
			case 'file':
				break;
			case 'folders':
				break;
			case 'files':
				break;
		}
		
		return $ret;
	}
	
	function setInType() {
		if (is_dir($this->_InFF)) {
			$this->_InType = 'folder';
		} elseif (is_file($this->_InFF)) {
			$this->_InType = 'file';
		} elseif (is_array($this->_InFF)) {
			
			$dir = $file = 0;
			foreach ($this->_InFF as $val) {
				if (is_dir($val)) {
					$dir = 1;
					continue;
				}
				if (is_file($val)) {
					$file = 2;
					continue;
				}
			}
			
			switch ($dir+$file) {
				case 0:
					$this->_InType = 'error';
					break;
				case 1:
					$this->_InType = 'folders';
					break;
				case 2:
					$this->_InType = 'files';
					break;
				case 3:
					$this->_InType = 'mix';
					break;
				default:
					$this->_InType = 'error';
					break;
			}
		} else {
			$this->_InType = 'error';
		}
	}
	
	function fileZip($files = array()) {
		
	}
	/**
	* @desc  create compress file by folder
	*
	* @param array $missfile		the file we don't want to include
	* @param array $fromString		set by self
	* 								eg: add strin 'this is my file' into new file 'info.ini'
	* 									set like this: array(array('info.ini','this is my file'));
	*/
	function folderZip($missfile=array(), $addfromString=array()){
		$dir = $this->_InFF;
		$filename = $this->_OutFile;
		if(!file_exists($dir) || !is_dir($dir)){
			$this->setError('Can not exists dir:'.$dir);
			return false;
		}
		
		$dir = str_replace('\\','/',$dir);
		if(file_exists($filename)){
			$this->setError('the zip file '.$filename.' has exists !');
			return false;
		}
		
		$files = array();
		$this->getFolderFiles($dir,$files);
		if(empty($files)){
			$this->setError(' the dir is empty');
			return false;
		}
	
		$res = $this->_ZipObj->open($filename, ZipArchive::CREATE);
		if ($res === TRUE) {
			foreach($files as $v){
				if(!in_array(str_replace($dir.'/','',$v),$missfile)){
					$this->_ZipObj->addFile($v,str_replace($dir.'/','./',$v));
				}
			}
			if(!empty($addfromString)){
				foreach($addfromString as $v){
					$this->_ZipObj->addFromString($v[0],$v[1]);
				}
			}
			$this->_ZipObj->close();
			
			return true;
		} else {
			return false;
		}
	}

	function getFolderFiles($dir, &$files=array()){
		if(!file_exists($dir) || !is_dir($dir)){
			return false;
		}
		
		if(substr($dir, -1) == '/'){
			$dir = substr($dir, 0, strlen($dir) - 1);
		}
		
		$_files = scandir($dir);
		foreach($_files as $v){
			if($v != '.' && $v!='..'){
				if(is_dir($dir.'/'.$v)){
					$this->getFolderFiles($dir.'/'.$v,$files);
				} else {
					$files[] = $dir.'/'.$v;
				}
			}
		}
		
		return $files;
	}
}