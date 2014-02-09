DTPDO
=====

Extends php PDO functions and let you create CRUD query with arrays.

Let's explain functions by exampes. 

In order to do our examples we need a table ...


    CREATE TABLE IF NOT EXISTS `user` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
          `name` varchar(25) NOT NULL,
          `surname` varchar(25) NOT NULL,
          `age` int(11) NOT NULL,
          `city` varchar(25) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;
    
    
    INSERT INTO `user` (`id`, `name`, `surname`, `age`, `city`) VALUES
    (1, 'John', 'Smith', 32, 'Boston'),
    (2, 'James', 'Brown', 39, 'New York'),
    (3, 'Robert', 'Wilson', 52, 'Washington');


... and a instance of the class in a php file. 

    <?php

    include("DTPDO/DTPDO.class.php");
    
    $dbh = new DTPDO("mysql:host={$hostname};dbname={$dbname}", $username, $password);
    $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );        

    [..]

    ?>

## insertRecord
`insertRecord($table, $param)`: Insert a record in a table by a given array of values

* param string $table: table name
* param array $param: associative array ("field1" => "value 1", ..., "fieldn" => "value n") 

es. 

    <?php
    
    $values= array(
                "id" => 0,
                "name" => "Charles", 
                "surname" => "Miller",
                "age" => "72",
                "city" => "Dallas"
        );
    
    $dbh->insertRecord("user",$values);

    ?>
    
## updateRecord
----------------
`updateRecord($table, $param, $key)`: Update a record in a table by a ginen array
 
* param string $table: table name
* param array $param: associative array ("field1" => "value 1", ..., "fieldn" => "value n") 
* param string/array $key

es. 

    <?php
        
    $values= array(
                "id" => 4,
                "age" => "62",
                "city" => "Los Angeles"
        );
    
    $dbh->updateRecord("user",$values,"id");
    
    ?>
    

getValue
--------
`getValue($query, $fetchMode = PDO::FETCH_NUM)`: Get a value from a given query
 
* param string $query
* param string $fetchMode = PDO::FETCH_NUM
* return string : value of the first field of the first row


getValues
---------
`getValues($query, $fetchMode = PDO::FETCH_NUM)`: Get an array of values from a given query

* param type $query
* param string $fetchMode = PDO::FETCH_NUM
* return array : vector of values of the query of the first row


getListValue
------------
`getListValue($query, $fetchMode = PDO::FETCH_NUM, $index = 1)`: Get an array of value, index is the first field of the query, value is the second field of the query

* param string $query
* param $fetchMode = PDO::FETCH_NUM
* param $index = 1, "1" array key is the first value of the quesry, "0" array key is incremental
* return array


getListValues
-------------
`getListValues($query, $fetchMode = PDO::FETCH_NUM, $index = 0)`: Get an array of array, index is the first field of the query, array contains all the fields of the query

* @param string $query
* @param $fetchMode = PDO::FETCH_NUM
* @param $index = 1, "1" array key is the first value of the quesry, "0" array key is incremental
* @return array


prepareInsertQuery
------------------
`prepareInsertQuery($table, $param)`: Prepare an insert query by a ginen array

* param string $table: table name
* param array $param: associative array ("field1" => "value 1", ..., "fieldn" => "value n") 
* return array(query,values)



prepareUpdateQuery
------------------
`prepareUpdateQuery($table, $param, $key)`: Prepare an update query by a ginen array
 
* param string $table: table name
* param array $param: associative array ("field1" => "value 1", ..., "fieldn" => "value n") 
* param string/array $key: table key
* return array(query,values)

 
FAQ
===

License
-------
The MIT License (MIT)

Website
-------
http://www.dtmind.com