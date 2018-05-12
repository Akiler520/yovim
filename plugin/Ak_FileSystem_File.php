<?php
/**
 *	file class for handle file in disk
 * 
 *	@author		akiler <532171911@qq.com>
 *	@copyright	2010-2013
 *	@version	1.0
 *	@package	LIB-Ak
 *
 *	$Id: Ak_FileSystem_File.php 2013-01-11 akiler $
 */

class Ak_FileSystem_File
{
    /**
     * this returns an array of all of the files of a set type in a directory path
     * if type is an array then it will return all files of the types in the array ( $types = array('png', 'jpg', 'gif'); )
     *
     * @param string $path, the filepath to search
     * @param mixed $type, the file extension to return
     * @param string $appendPath, the path to append to the returned files
     */
    public static function getFilesByType($path, $count = 100, $type = false, $appendPath = false, $includeExtension = true)
    {
    	$count_f = 0;
    	
        if (is_dir($path)) {
            $dir = scandir($path); //open directory and get contents
            if (is_array($dir)) { //it found files
                $returnFiles = false;
                foreach ($dir as $file) {
                    if (!is_dir($path . '/' . $file)) {
                    	
                        if ($count_f >= $count) {
                        	break;
                        }
                        
                        if ($type) { //validate the type
                            $fileParts = explode('.', $file);
                            if (is_array($fileParts)) {
                                $fileType = array_pop($fileParts);
                                $file = implode('.', $fileParts);
                             
                                //check whether the filetypes were passed as an array or string
                                if (is_array($type)) {
                                    if (in_array($fileType, $type)) {
                                        $filePath =  $appendPath . $file;
                                        if ($includeExtension == true) {
                                            $filePath .= '.' . $fileType;
                                        }
                                        $returnFiles[] = $filePath;
                                    }
                                } else {
                                    if ($fileType == $type) {
                                        $filePath =  $appendPath . $file;
                                        if ($includeExtension == true) {
                                            $filePath .= '.' . $fileType;
                                        }
                                        $returnFiles[] = $filePath;
                                    }
                                }
                            }
                        } else { //the type was not set.  return all files and directories
                            $returnFiles[] = $file;
                        }
                        
                        $count_f++;
                    }
                }

                if ($returnFiles) {
                    return $returnFiles;
                }
            }
        }
    }

    /**
     * creates a new file from a string
     *
     * @param string $path
     * @param string $content
     * @return bool
     */
    public static function saveFile($path, $content)
    {
        $content = stripslashes($content);

        $ret = @file_put_contents($path, $content);
        
        return $ret ? true : false;
    }

    /**
     * rename the selected file
     *
     * @param string $source
     * @param string $newName
     */
    public static function rename($source, $newName)
    {
        if (file_exists($source)) {
			return @rename($source, $newName);
        }
        
        return false;
    }

    /**
     * copy a file
     *
     * @param string $source
     * @param string $target
     * 
     * @return bool
     */
    public static function copy( $source, $target )
    {
        if (file_exists( $source )) {
            return @copy($source, $target);
        }
        
        return false;
    }

    /**
     * move a file
     *
     * @param string $source
     * @param string $target
     * 
     * @return bool
     */
    public static function move($source, $target)
    {
        if (file_exists($source)) {
            return @rename($source, $target);
        }
        
        return false;
    }

    /**
     * delete a file
     *
     * @param string $path
     */
    public static function delete($path)
    {
        @unlink($path);
    }
    
    /**
     * create new file
     *
     * @param string $path
     */
    public static function create($path)
    {
    	@touch($path);
    }

    /**
     * this function cleans up the filename
     * it strips ../ and ./
     * it spaces with underscores
     *
     * @param string $fileName
     */
    public static function cleanFilename($fileName)
    {
        $fileName = str_replace('../', '', $fileName);
        $fileName = str_replace('./', '', $fileName);
        $fileName = str_replace(' ', '_', $fileName);
        
        return $fileName;
    }

    public static function getFileExtension($filename)
    {
        if (!empty($filename)) {
            $fileparts = explode(".", $filename);
            if (is_array($fileparts)) {
                $index = count($fileparts) - 1;
                $extension = $fileparts[$index];
                return $extension;
            }
        }
        
        return null;
    }
    
    /**
     * get the file info
     * include file name, file extension, full of file name
     *
     * @param string $filename
     * @return array
     */
    public static function getFileInfo($filename, $toLower = true)
    {
    	if (empty($filename)) {
    		return null;
    	}
    	
    	$info = array();
    	
    	$info['basename'] = $filename;
    	$info['filename'] = substr($filename, 0, strrpos($filename,'.'));
    	$info['extension'] = substr(strrchr($filename,'.'), 1);
    	
    	if ($toLower) {
    		$info['filename'] = strtolower($info['filename']);
    		$info['extension'] = strtolower($info['extension']);
    	}
    	
    	return $info;
    }
    
    /**
     * get the information of file by line
     *
     * @param string $file_path
     * 
     * @return array|bool
     */
    public static function getFileByLine($filePath)
    {
    	if (!($fp = fopen($filePath, 'r'))) {
			return false;
		}
	
		while (!feof($fp)) {
			$buf = fgets($fp, 1024);
			$buf = trim($buf, " \r\n");
	
			if (empty($buf)) {
				continue;
			}
	
			$list[] = $buf;
		}
		
		fclose($fp);
		
		return $list;
    }
}