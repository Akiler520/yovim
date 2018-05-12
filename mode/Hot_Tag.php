<?php
/**
 * Hot tag mode of Yovim
 *
 * @copyright Copyright (C) 2014 Yovim
 *
 * 2014-10-12 12:46:16
 * @author Akiler
 */
class Hot_Tag extends Yov_Mode{

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

    public function getHottest($limit = 30){
        $hottest = $this->dbObj->select('', '', 'count DESC', $limit);

        return $hottest;
    }

    /**
     * update the tag info
     * if not exist, add new, or update the count number
     *
     * @param $tag
     * @return bool|int
     */
    public function updateTag($tag){
        if(empty($tag)){
            return false;
        }

        $tagInfo = $this->dbObj->getRow('tag="'.$tag.'"');

        $ret = false;

        if(!empty($tagInfo)){
            // increase the count of tag
            $data_tag = array('count' => $tagInfo['count']+1);

            $ret = $this->dbObj->update($data_tag, 'id='.$tagInfo['id']);
        }else{
            // insert new tag
            $data_tag = array(
                'tag'   => $tag,
                'count' => 1
            );

            $ret = $this->dbObj->insert($data_tag);
        }

        return $ret;
    }
}