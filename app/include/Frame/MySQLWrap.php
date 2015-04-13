<?php

class MySQLWrap {

    public static function connect($config) {
        mysql_pconnect($config['databaseHost'], $config['databaseUser'], $config['databasePass']) or die('Unable to connect to MySQL server: ' . mysql_error());
        if (!mysql_select_db($config['databaseName'])) {
            die('Unable to select database '.$config['databaseName'].': '.mysql_error());
        }
    }

    public static function selectEntityByID($entity, $id) {
        if (!isset($entity) || !isset($id)) {
            return array();
        }
        $sql = "SELECT * FROM `$entity` WHERE id = $id";
        
        $q = mysql_query($sql);   
        $row = mysql_fetch_array($q, MYSQL_ASSOC);

        if ($row) {
            $row = TextUtils::stripSlashesArray($row);
        } else {
            $row = false;
        }
        
        mysql_free_result($q);
        return $row;
    }

    public static function deleteEntityByID($entity, $id) {
        $sql = "DELETE FROM $entity WHERE id = $id";
	$res = mysql_query($sql);
	return (mysql_errno() == 0);
    }

    public static function deleteEntities($entity, $criteria = array()) {
        if (!is_array($criteria)) {
            return false;
        }

        $where = '';
        foreach($criteria as $key => $value) {
            if ($where !== '') {
                $where .= ', ';
            }

            if (is_float($value) || is_int($value) || is_double($value)) {
                $where .= "`$key` = $value";
            } else {
                $where .= "`$key` = '" . addslashes($value) . "'";
            }
           
        }

        if ($where === '') {
            $where = '1';
        }

        $sql = "DELETE FROM `$entity` WHERE $where";
        
	$res = mysql_query($sql);
	return (mysql_errno() == 0);
    }

    public static function selectEntities($entity, $criteria = array()) {
        if (!is_array($criteria)) {
            return false;
        }

        $where = '';
        foreach($criteria as $key => $value) {
            if ($where !== '') {
                $where .= ' AND ';
            }

            if (is_float($value) || is_int($value) || is_double($value)) {
                $where .= "`$key` = $value";
            } else {
                $where .= "`$key` = '" . addslashes($value) . "'";
            }

        }

        if ($where === '') {
            $where = '1';
        }


        $sql = "SELECT * FROM `$entity` WHERE $where";
	
	return self::select($sql);
    }

    public static function updateEntity($entity, $data) {

        if (!is_array($data)) {
            return false;
        }

        $up = '';
        $id = -1;
        foreach($data as $key => $value) {
            if (strtoupper($key) !== 'ID') {
                if ($up !== '') {
                    $up .= ', ';
                }

                if (is_float($value) || is_int($value) || is_double($value)) {
                    $up .= "`$key` = $value";
                } else {
                    $up .= "`$key` = '" . addslashes($value) . "'";
                }
            } else {
                $id = $value;
            }
        }


        $sql = "UPDATE `$entity` SET $up WHERE id = $id";

	$res = mysql_query($sql);

        if (mysql_errno() !== 0) {
            Logger::log('Error in MySQLWrap::updateEntity: '. $sql);
            Logger::log(mysql_error());
            return false;
        } else {
            //Logger::log('Success in MySQLWrap::updateEntity: '. htmlspecialchars($sql, ENT_COMPAT, 'UTF-8'));
            return true;
        }
    }

    public static function insertEntity($entity, $data) {

        if (!is_array($data)) {
            return false;
        }

        $keys = '';
        $values = '';
        
        foreach($data as $key => $value) {
            if (strtoupper($key) !== 'ID') {
                if ($keys !== '') {
                    $keys .= ', ';
                }

                if ($values !== '') {
                    $values .= ', ';
                }

                $keys .= "`".$key."`";
                if (is_float($value) || is_int($value) || is_double($value)) {
                    $values .= addslashes($value);
                } else {
                    $values .= "'" . addslashes($value) . "'";
                }
            }
        }


        $sql = "INSERT INTO `$entity` ($keys) VALUES ($values)";
	$res = mysql_query($sql);
        if (mysql_errno() == 0) {
            return mysql_insert_id();
        }
        else {
            Logger::log('Error in insertEntity: '.$sql);
            Logger::log(mysql_error());
            return -1;
        }
    }

    public static function select($sql) {
        $q = mysql_query($sql);

        $res = array();

        if (mysql_errno() === 0) {

            while ($row = mysql_fetch_array($q, MYSQL_ASSOC)) {
                TextUtils::stripSlashesArray($row);
                $res[] = $row;
            }

            mysql_free_result($q);


            //Logger::log('Execute SQL: ' . $sql);
        } else {
            Logger::log('Unable to execute SQL: ' . $sql);
        }

        
        return $res;

    }

    public static function query($sql) {
        $q = mysql_query($sql);

        if (mysql_errno() !== 0) {

            Logger::log('Unable to execute SQL: ' . $sql);
            Logger::log(mysql_error());
            return false;

        } else {
            Logger::log('Query SQL: ' . $sql);
            return true;
        }
    }

}

?>
