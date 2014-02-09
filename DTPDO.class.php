<?php

/**
 * DTPDO Class <http://www.dtmind.com>
 * Extends php PDO functions and let you create CRUD query with arrays
 *
 * @version version 1.0, 15/01/2014
 * @author Stefano Oggioni <stefano.oggioni@dtmind.com>
 * @copyright Copyright 2014 - DTMind
 * @link http://www.dtmind.com
 * @license The MIT License (MIT)
 *
 */
class DTPDO extends PDO {

    /**
     * Prepare an insert query by a ginen array
     * 
     * @param string $table: table name
     * @param array $param: associative array ("field1" => "value 1", ..., "fieldn" => "value n") 
     * @return array(query,values)
     */
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

    /**
     * Prepare an update query by a ginen array
     * 
     * @param string $table: table name
     * @param array $param: associative array ("field1" => "value 1", ..., "fieldn" => "value n") 
     * @param string/array $key: table key
     * @return array(query,values)
     */
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

    /**
     * Insert a record in a table by a given array
     * 
     * @param string $table: table name
     * @param array $param: associative array ("field1" => "value 1", ..., "fieldn" => "value n") 
     * @return 
     */
    public function insertRecord($table, $param) {

        $result = $this->prepareInsertQuery($table, $param);
        $this->prepare($result["query"])->execute($result["values"]);
    }

    /**
     * Update a record in a table by a ginen array
     * 
     * @param string $table: table name
     * @param array $param: associative array ("field1" => "value 1", ..., "fieldn" => "value n") 
     * @param string/array $key
     * @return 
     */
    public function updateRecord($table, $param, $key) {

        $result = $this->prepareUpdateQuery($table, $param, $key);
        $this->prepare($result["query"])->execute($result["values"]);
    }

    /**
     * Get a value from a given query
     * 
     * @param string $query
     * @return string : value of the first field of the first row
     */
    public function getValue($query, $fetchMode = PDO::FETCH_NUM) {

        $sth = $this->query($query);
        $sth->setFetchMode($fetchMode);

        if ($sth->rowCount() == 0) {
            return NULL;
        } else {
            $row = $sth->fetch();
            return $row[0];
        }
    }

    /**
     * Get an array of values from a given query
     * 
     * @param type $query
     * @return array : vector of values of the query of the first row
     */
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

    /**
     * Get an array of value, index is the first field of the query, value is the second field of the query
     * 
     * @param string $query
     * @return array
     */
    public function getListValue($query, $fetchMode = PDO::FETCH_NUM, $index = 1) {

        $rows = $this->query($query);
        $sth->setFetchMode($fetchMode);

        while ($row = $sth->fetch()) {

            if ($index == 0)
                $myResult[] = $row[1];
            else
                $myResult[$row[0]] = $row[1];
        }

        return $myResult;
    }

    /**
     * Get an array of array, index is the first field of the query, array contains all the fields of the query
     * 
     * @param string $query
     * @return array
     */
    public function getListValues($query, $fetchMode = PDO::FETCH_NUM, $index = 0) {

        $sth = $this->query($query);
        $sth->setFetchMode($fetchMode);


        $myResult = array();

        while ($row = $sth->fetch()) {
            $myValue = array();

            if ($fetchMode == PDO::FETCH_NUM) {
                for ($j = 0; $j < count($row); $j++)
                    $myValue[] = $row[$j];

                if ($index == 0)
                    $myResult[] = $myValue;
                else
                    $myResult[$row[0]] = $myValue;
            }
            else {
                if ($index == 0)
                    $myResult[] = $row;
                else
                    $myResult[current($row)] = $row;
            }
        }

        return $myResult;
    }

}

?>