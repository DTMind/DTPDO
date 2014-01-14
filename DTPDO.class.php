<?php
/**
* DTPDO Class <http://www.dtmind.com>
* extends php PDO functions and let you create CRUD query with arrays
*
* @author Stefano Oggioni <stefano.oggioni@dtmind.com>
* @copyright Copyright 2014 - DTMind
* @link http://www.dtmind.com
* @license GNU GENERAL PUBLIC LICENSE
* 
*/

class DTPDO extends PDO {

    // ---
    public function prepareInsertQuery($table, $param) {

        $query1 = "";
        $query2 = "";
        $fields = array();

        foreach ($param as $field => $value) {

            $query1.=(($query1 != "") ? ", " : "") . "`{$field}`";
            $query2.=(($query2 != "") ? ", " : "") . ":{$field}";

            $fields[":{$field}"] = $value;
        }

        return array("query" => "INSERT INTO `{$table}` ({$query1}) VALUES({$query2});", "values" => $fields);
    }

    // ---	
    public function prepareUpdateQuery($table, $param, $key) {

        $query1 = "";
        $fields = array();

        foreach ($param as $field => $value) {

            $query1.=(($query1 != "") ? ", " : "") . "`{$field}`=:{$field}";

            $fields[":{$field}"] = $value;
        }

        if (is_array($key)) {
            $query2 = "";

            foreach ($key as $value) {
                $query2 = (($query2 != "") ? " AND " : "") . "`{$value}`=:{$value}";
            }
        } else {
            $query2 = "`{$key}`=:{$key}";
        }

        return array("query" => "UPDATE {$table} SET {$query1} WHERE {$query2}", "values" => $fields);
    }

    // ---
    public function insertRecord($table, $param) {

        $result = $this->prepareInsertQuery($table, $param);
        $this->prepare($result["query"])->execute($result["values"]);
    }

    // ---
    public function updateRecord($table, $param, $key) {

        $result = $this->prepareUpdateQuery($table, $param, $key);
        $this->prepare($result["query"])->execute($result["values"]);
    }

    // ---	
    public function getValue($query) {

        $sth = $this->query($query);
        $sth->setFetchMode(PDO::FETCH_NUM);

        if ($sth->rowCount() == 0) {
            return NULL;
        } else {
            $row = $sth->fetch();
            return $row[0];
        }
    }

    // ---	
    public function getValues($query, $fetchMode = PDO::FETCH_NUM) {

        $sth = $this->query($query);
        $sth->setFetchMode($fetchMode);

        if ($sth->rowCount() == 0) {
            return NULL;
        } else {
            $row = $sth->fetch();
            return $row;
        }
    }

    // ---
    public function loadValue($query, $addValue = array()) {

        $sth = $this->query($query);
        $sth->setFetchMode(PDO::FETCH_NUM);

        if ($addValue == "")
            $myResult = array();
        else
            $myResult = $addValue;


        while ($row = $sth->fetch()) {
            $myResult[$row[0]] = $row[1];
        }

        return $myResult;
    }

    // ---
    public function loadValues($query) {

        $sth = $this->query($query);
        $sth->setFetchMode(PDO::FETCH_NUM);

        $myResult = array();

        while ($row = $sth->fetch()) {
            $myValue = array();

            for ($j = 0; $j < $sth->rowCount(); $j++)
                $myValue[] = $row[$j];

            $myResult[$row[0]] = $myValue;
        }

        return $myResult;
    }

    // ---
    public function loadSimpleValues($query) {

        $sth = $this->query($query);
        $sth->setFetchMode(PDO::FETCH_NUM);

        if ($addValue == "")
            $myResult = array();
        else
            $myResult = $addValue;


        while ($row = $sth->fetch()) {
            $myResult[] = $row[1];
        }

        return $myResult;
    }

    // ---
    public function copyLine() {
        
    }

    // --- Trace function
}

?>