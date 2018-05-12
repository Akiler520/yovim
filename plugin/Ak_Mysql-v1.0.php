<?php
class Ak_Mysql_v1
{
    /**
     * connection of database
     * @var
     */
    private $connid = null;

    /**
     * Database name
     * @var
     */
    private $dbname = null;

    /**
     * if debug
     * @var int
     */
    private  $debug = true;

    function connect($dbhost, $dbuser, $dbpw, $dbname = '', $pconnect = 0, $charset = 'utf8')
    {
        if($pconnect == 1)
        {
            $this->connid = @mysql_pconnect($dbhost, $dbuser, $dbpw);
        }
        else
        {
            $this->connid = @mysql_connect($dbhost, $dbuser, $dbpw, true);
        }
        if(!$this->connid) $this->halt('Can not connect to MySQL server');
        if($this->version() > '4.1')
        {
            $serverset = $charset ? "character_set_connection='$charset',character_set_results='$charset',character_set_client=binary" : '';
            $serverset .= $this->version() > '5.0.1' ? ((empty($serverset) ? '' : ',')." sql_mode='' ") : '';
            $serverset && mysql_query("SET $serverset", $this->connid);
        }
        if($dbname && !@mysql_select_db($dbname , $this->connid)) $this->halt('Cannot use database '.$dbname);
        $this->dbname = $dbname;
        return $this->connid;
    }

    function debug($debug){
        $this->debug = $debug;
    }
    
    function set_connect($connect) 
    {
    	$this->connid = $connect;
    }

    function select_db($dbname)
    {
        if(!@mysql_select_db($dbname , $this->connid)) return false;
        $this->dbname = $dbname;
        return true;
    }

    function query($sql , $type = '')
    {
        $func = $type == 'UNBUFFERED' ? 'mysql_unbuffered_query' : 'mysql_query';
        if(!($query = @$func($sql , $this->connid)) && $type != 'SILENT') $this->halt('MySQL Query Error', $sql);
        return $query;
    }

    function query_array($sql)
    {
        $result = $this->query($sql);
        $array = array();
        while ($r = $this->fetch_array($result))
        {
            $array[] = $r;
        }
        $this->free_result($result);
        return $array;
    }

    function query_limit($sql,$start,$num)
    {
        $sql .= " limit $start,$num";
        return $this->query_array($sql);
    }

    function getRow($sql, $type = '')
    {
        $query = $this->query($sql, $type);
        $rs = $this->fetch_array($query);
        $this->free_result($query);
        return $rs ;
    }

    function select($sql, $keyfield = '', $result_type = MYSQL_ASSOC)
    {
        $array = array();
        $result = $this->query($sql);
        while($r = $this->fetch_array($result, $result_type))
        {
            if($keyfield)
            {
                $key = $r[$keyfield];
                $array[$key] = $r;
            }
            else
            {
                $array[] = $r;
            }
        }
        $this->free_result($result);

        $array = Ak_String::stripslashes_deep($array);

        return $array;
    }

    function insert($tablename, $array)
    {
        $array = Ak_String::addslashes_deep($array);

        $sql = "INSERT INTO `$tablename`(`".implode('`,`', array_keys($array))."`) VALUES('".implode("','", $array)."')";

        return $this->query($sql);
    }

    function update($tablename, $array, $where = '')
    {
        $array = Ak_String::addslashes_deep($array);
        if($where)
        {
            $sql = '';
            foreach($array as $k=>$v)
            {
                $sql .= ", `$k`='$v'";
            }
            $sql = substr($sql, 1);
            $sql = "UPDATE `$tablename` SET $sql WHERE $where";
        }
        else
        {
            $sql = "REPLACE INTO `$tablename`(`".implode('`,`', array_keys($array))."`) VALUES('".implode("','", $array)."')";
        }

        return $this->query($sql);
    }

    function delete($tablename, $where)
    {
        $sql = 'DELETE FROM '.$tablename.' WHERE '.$where;

        return $this->query($sql);
    }

    function fetch_array($query, $result_type = MYSQL_ASSOC)
    {
        if ($query) {
            //			return mysql_fetch_array($query);
            return mysql_fetch_array($query, $result_type);
        }

        return false;
    }

    function affected_rows()
    {
        return mysql_affected_rows($this->connid);
    }

    function num_rows($query)
    {
        return mysql_num_rows($query);
    }

    function num_fields($query)
    {
        return mysql_num_fields($query);
    }

    function result($query, $row)
    {
        return @mysql_result($query, $row);
    }

    function free_result(&$query)
    {
        //		return mysql_free_result($query);
        if ($query) {
            return mysql_fetch_array($query);
        }

        return false;
    }

    function insert_id()
    {
        return mysql_insert_id($this->connid);
    }

    function fetch_row($query)
    {
        return mysql_fetch_row($query);
    }

    function escape($string)
    {
        if(!is_array($string)) return str_replace(array('\n', '\r'), array(chr(10), chr(13)), mysql_real_escape_string($string, $this->connid));
        foreach($string as $key=>$val) $string[$key] = $this->escape($val);
        return $string;
    }

    function version()
    {
        return mysql_get_server_info();
    }

    function close()
    {
        return mysql_close($this->connid);
    }

    function error()
    {
        return @mysql_error($this->connid).'('.intval(@mysql_errno($this->connid)).')';
    }

    function halt($message = '', $sql = '', $cut = '')
    {
        if($this->debug)
        {
            echo "MySQL Error:{$this->error()}{$cut}";
            if(!empty($sql)) echo "MySQL Query:{$sql}{$cut}";
            if(!empty($message)) echo "Message:{$message}{$cut}";
            exit;
        }
    }
}
?>