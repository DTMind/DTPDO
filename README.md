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

insertRecord
------------
`insertRecord($table, $param)`: Insert a record in a table by a given array of values

* param string $table: table name
* param array $param: associative array ("field1" => "value 1", ..., "fieldn" => "value n") 

##### example #1

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
    
updateRecord
------------
`updateRecord($table, $param, $key)`: Update a record in a table by a ginen array
 
* param string $table: table name
* param array $param: associative array ("field1" => "value 1", ..., "fieldn" => "value n") 
* param string/array $key

##### example #2

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

##### example #3
Code:

    <?php
        getValue("SELECT surname FROM user WHERE id=2");
    ?>

Function result:

    Brown

getValues
---------
`getValues($query, $fetchMode = PDO::FETCH_NUM)`: Get an array of values from a given query

* param type $query
* param string $fetchMode = PDO::FETCH_NUM
* return array : vector of values of the query of the first row


##### example #4
Code:

    <?php
        getValues("SELECT * FROM user WHERE id=2",PDO::FETCH_ASSOC);
    ?>

Function result (array):

    Array(
        id => 2
        name => James
        surname => Brown
        age => 39
        city => New York
    );

getListValue
------------
`getListValue($query, $index = 1)`: Get an array of value, index is the first field of the query, value is the second field of the query

* param string $query
* param $index = 1, "1" array key is the first value of the quesry, "0" array key is incremental
* return array

##### example #5
Code: the index is the id value

    <?php
        getListValue("SELECT * FROM user WHERE id>=2");
    ?>

Function result (array):

    Array(
        2 => James
        3 => Robert
    );

##### example #6
Code: the index is an incremental value

    <?php
        getListValue("SELECT * FROM user WHERE id>=2", 0);
    ?>

Function result (array):

    Array(
        0 => James
        1 => Robert
    );


getListValues
-------------
`getListValues($query, $fetchMode = PDO::FETCH_NUM, $index = 0)`: Get an array of array, index is the first field of the query, array contains all the fields of the query

* param string $query
* param $fetchMode = PDO::FETCH_NUM
* param $index = 1, "1" array key is the first value of the quesry, "0" array key is incremental
* return array

##### example #7
Code: the array as an incremental index

    <?php
        getListValues("SELECT * FROM user")
    ?>

Function result (array):

    Array(
        0=> Array(
            0 => 1
            1 => John
            2 => Smith
            3 => 32
            4 => Boston
        );
        1=> Array(
            0 => 2
            1 => James
            2 => Brown
            3 => 39
            4 => New York
        );
        2=> Array(
            0 => 3
            1 => Robert
            2 => Wilson
            3 => 52
            4 => Washington
        );
    );


##### example #8
Code: the first value is the key of the array

    <?php
        getListValues("SELECT * FROM user",PDO::FETCH_ASSOC,1)
    ?>

Function result (array):

    Array(
        1=> Array(
            id => 1
            name => John
            surname => Smith
            age => 32
            city => Boston
        );
        2=> Array(
            id => 2
            name => James
            surname => Brown
            age => 39
            city => New York
        );
        3=> Array(
            id => 3
            name => Robert
            surname => Wilson
            age => 52
            city => Washington
        );
    );

prepareInsertQuery
------------------
`prepareInsertQuery($table, $param)`: Prepare an insert query by a ginen array

* param string $table: table name
* param array $param: associative array ("field1" => "value 1", ..., "fieldn" => "value n") 
* return array(query,values)



prepareUpdateQuery
------------------
`prepareUpdateQuery($table, $param, $key)`: Prepare an update query by a given array
 
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