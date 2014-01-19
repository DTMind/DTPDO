DTPDO
=====

Extends php PDO functions and let you create CRUD query with arrays.

Let's explain functionality by exampes


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
