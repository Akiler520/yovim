<?php
/**
 * Main Mode of Yovim
 *
 * @copyright Copyright (C) 2014 Yovim
 *
 * 2014-10-22 13:46:16
 * @author Akiler
 */
class Yov_Mode{
    /**
     * the prefix of data table
     * @var null
     */
    public $dbPrefix = null;

    /**
     * current name of data table
     * @var null
     */
    public  $tableName = null;

    /**
     * the object of Ak_Mysql
     * @var Ak_Mysql|null|object
     */
    public $dbObj = null;

    /**
     * the request from client
     *
     * @var null
     */
    public $request = null;

    function __construct(){
        $this->init();
        $this->dbPrefix = YOV_DB_PREFIX;
        $this->dbObj = Yov_init::getInstance()->db;

        $this->dbObj->setFieldCachePath(TMP_PATH.'cache/db/');

        $this->dbObj->setTablePrefix($this->dbPrefix);
        $this->dbObj->setTable($this->tableName);

        $this->request = Yov_Router::getInstance()->getRequest();
    }

    function init(){}

    function setPrefix($prefix){
        $this->dbPrefix = $prefix;
        $this->dbObj->setTablePrefix($this->dbPrefix);
    }

    function setTableName($table){
        $this->tableName = $this->dbPrefix.$table;
        $this->dbObj->setTable($table);
    }

    function getDbPrefix(){
        return $this->dbPrefix;
    }

    function getById($id){
        $ret = $this->dbObj->getById($id);

        return $ret;
    }

    function getCount($where = '', $fields = ''){
        return $this->dbObj->count($where, $fields);
    }

    function getLastSql(){
        return $this->dbObj->getLastSql();
    }

    function insert($data){
        if(empty($data)) {
            return false;
        }
        $this->dbObj->insert($data);

        return $this->dbObj->getInsertID();
    }

    function update($data, $where=''){
        if(empty($data)) {
            return false;
        }

        return $this->dbObj->update($data, $where);
    }

    function delete($ids = array(), $where = ''){
        if(empty($ids) && empty($where)) {
            return false;
        }

        return $this->dbObj->delete($ids, $where);
    }

    /**
     * get list of current table
     *
     * @param array $filter
     * @return mixed
     */
    function lists($filter = array()){
        $column = $this->tableName.'.*';

        if(isset($filter['column'])){
            $tmp_col = array();
            foreach($filter['column'] as $val_col){
                $tmp_col[] = $this->tableName.'.'.$val_col;
            }

            $column = implode(',', $tmp_col);
        }

        $join = '';

        // if set 'id_user', then try to get the user name from user table
        if(isset($filter['column']) && in_array('id_user', $filter['column']) && $this->tableName != ($this->dbPrefix.'user')){
            $join .= ' LEFT JOIN '.$this->dbPrefix.'user AS y_u ON y_u.id='.$this->tableName.'.id_user';
            $column .= ',y_u.username';
        }

        if(isset($filter['_list_type']) && $filter['_list_type'] == 'sourceList'){
            $column .= ',(SELECT COUNT(y_re.id_source) FROM '.$this->dbPrefix.'recommend AS y_re WHERE y_re.id_source='.$this->tableName.'.id) AS num_rec';
        }

        $where = ' WHERE '.$this->tableName.'.active=1 ';

        if(isset($filter['where'])){
            $where .= ' AND ('.$filter['where'].') ';
        }

        $sql = 'SELECT '.$column.' FROM '.$this->tableName.' ';

        $limit = '';
        $order = '';

        if($filter['limit']){
            $limit = ' LIMIT '.(($filter['page']-1)*$filter['limit']).','.$filter['limit'];
        }

        if($filter['order']){
            $order = ' ORDER BY '.$filter['orderby'].' '.$filter['order'];
        }

        $sql = $sql.$join.$where.$order.$limit;

        $list = $this->dbObj->query($sql);

        return $list;
    }
}