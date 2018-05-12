<?php
/**
 * Recommend mode of Yovim
 *
 * @copyright Copyright (C) 2014 Yovim
 *
 * 2014-10-12 12:46:16
 * @author Akiler
 */
class Recommend extends Yov_Mode{

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

    public function getHottest($limit = 10){
        $sql = "SELECT src.name,src.id,COUNT(rec.id_source) AS num_rec FROM $this->tableName AS rec " .
            " LEFT JOIN ".$this->getDbPrefix()."source AS src" .
            " ON rec.id_source=src.id ".
            " GROUP BY id_source ORDER BY num_rec DESC LIMIT ".$limit;

        $top10 = $this->dbObj->query($sql);

        return $top10;
    }

    /**
     * get by given date type
     * 1=year, 2=month, 3=week, 4=day
     * 
     * @param int $dateType
     * @param int $limit
     * @return array|bool
     */
    public function getHotByDateType($dateType = 2, $limit = 10){
        $dateRange = Ak_String::getDateRange($dateType);

        $sql = "SELECT src.name,src.id,COUNT(rec.id_source) AS num_rec FROM $this->tableName AS rec " .
            " LEFT JOIN ".$this->getDbPrefix()."source AS src" .
            " ON rec.id_source=src.id ".
            " WHERE rec.time_add >= '".$dateRange['from']."' AND rec.time_add <= '".$dateRange['to']."'".
            " GROUP BY id_source ORDER BY num_rec DESC LIMIT ".$limit;

        $top10 = $this->dbObj->query($sql);

        return $top10;
    }
}