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

    include("DTPDO/DTPDO.class.php");
    
    $dbh = new DTPDO("mysql:host={$hostname};dbname={$dbname}", $username, $password);
    $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );        
    $dbh->query("SET CHARSET 'utf8'");


insertRecord($table, $param)
----------------------------
Insert a record in a table by a given array

@param string $table: table name

@param array $param: associative array ("field1" => "value 1", ..., "fieldn" => "value n") 

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
