<?php
ezcTestRunner::addFileToFilter( __FILE__ );

/**
CREATE TABLE `table`
(
  `from` integer unsigned not null auto_increment,
  `select` integer,
  PRIMARY KEY (`from`)
) TYPE=InnoDB;

CREATE TABLE `where`
(
  `like` integer unsigned not null auto_increment,
  `update` integer,
  PRIMARY KEY (`like`)
) TYPE=InnoDB;

CREATE TABLE `as`
(
   `and` integer,
   `or` integer
) TYPE=InnoDB;
*/

class Sequence extends Table
{
    public $column = null;
    public $trigger = null;

    public function getState()
    {
        return array(
            'column' => $this->column,
            'trigger' => $this->trigger,
        );
    }
}

?>
