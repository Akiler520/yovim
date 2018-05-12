<?php
/**
 * Source mode  of Yovim
 *
 * @copyright Copyright (C) 2014 Yovim
 *
 * 2014-10-11 12:46:16
 * @author Akiler
 */
class Source extends Yov_Mode{

    /**
     * current name of data table
     * @var null
     */
    public $tableName;

    /**
     * object of class
     * @var object
     */
    private static $_instance;

    function init(){
        $this->tableName = strtolower(__CLASS__);
    }

    static function getInstance()
    {
        if(!isset(self::$_instance)) {
            self::$_instance = new self();
        }

        self::$_instance->setTableName(strtolower(__CLASS__));

        return self::$_instance;
    }

    function search($filter){
        $condition = $filter;

        if(isset($condition['keyword'])){
            $where[] = $this->tableName.'.name LIKE "%'.$condition['keyword'].'%"';
            $where[] = $this->tableName.'.keywords LIKE "%'.$condition['keyword'].'%"';
            $where[] = $this->tableName.'.summary LIKE "%'.$condition['keyword'].'%"';
            $where[] = $this->tableName.'.description LIKE "%'.$condition['keyword'].'%"';

            $condition['where'] = implode(' OR ', $where);
        }

        $search_ret = $this->lists($condition);

        foreach($search_ret as $key_search => $val_search){
            $search_ret[$key_search]['name_search'] = str_replace($condition['keyword'], '<span class="highlight">'
                                                                .$condition['keyword'].'</span>' , $val_search['name']);
        }

        $ret['data'] = $search_ret;
        $ret['count'] = $this->getCount($condition['where']);

        return $ret;
    }

    function uniqueCheck($hashCode, $uniqType){
        $info = null;

        $fields = 'id,name';

        switch($uniqType){
            case 'source':
                $info = $this->dbObj->getRow('hash="'.$hashCode.'"', $fields);
                break;
            case 'snapshot':
                $info = $this->dbObj->getRow('hash_snap="'.$hashCode.'"', $fields);
                break;
            default:
                break;
        }

        $ret_data = array(
            "count" => empty($info) ? 0 : 1,
            "data"  => $info
        );

        /*if(empty($info)){
            // check the tmp file
        }*/

        return $ret_data;
    }

    /**
     * create thumb image for snapshot
     *
     * @param $srcFile
     * @param $targetFile
     * @return bool
     */
    public function createThumb($srcFile, $targetFile){
        Ak_Image::getInstance()->setSrcImg($srcFile);
        Ak_Image::getInstance()->setDstImg($targetFile);

        // run create
        $ret = Ak_Image::getInstance()->createImg(140, 90);

        return $ret;
    }

    /**
     * get details of source
     *
     * @param $id_source
     * @return array|bool
     */
    public function getDetail($id_source){
        if($id_source <= 0){
            return false;
        }

        $sql = 'SELECT y_src.*,y_u.username,(SELECT COUNT(y_rec.id) FROM '.$this->getDbPrefix().'recommend AS y_rec WHERE y_rec.id_source=y_src.id) AS num_rec ' .
            ' FROM '.$this->tableName.' AS y_src ' .
            ' LEFT JOIN '.$this->getDbPrefix().'user AS y_u ON y_u.id=y_src.id_user'.
            ' WHERE y_src.id='.$id_source;

        $ret = $this->dbObj->query($sql);

        return $ret[0];
    }

    /**
     * remove the AD code in source index file
     *
     * @param $id_source
     * @return bool
     */
    public function removeAD($id_source){
        $sourceInfo = $this->getById($id_source);

        $filePath = ROOT_PATH.$sourceInfo['link'].$sourceInfo['url'];

        if(!is_file($filePath)){
            return false;
        }

        // get content
        $contents = file_get_contents($filePath);
        /*$contents_new = preg_replace('/<script(.*?)src="\/gg_bd_ad.*?>(.*?)<\/script>/is', " ", $contents);*/
        $contents_new = preg_replace('/<script src="\/gg_bd_ad.*?>(.*?)<\/script>/is', " ", $contents);
        /*$contents_new = preg_replace('/<script type="text/javascript" src="\/gg_bd_ad.*?>(.*?)<\/script>/is', " ", $contents_new);*/
        $contents_new = preg_replace('/<script src="\/follow.js.*?>(.*?)<\/script>/is', " ", $contents_new);
        /*$contents_new = preg_replace('/<script type="text/javascript" src="\/follow.js.*?>(.*?)<\/script>/is', " ", $contents_new);*/

        file_put_contents($filePath, $contents_new);

        return true;
    }

    public function addAD($id_source){

    }
}