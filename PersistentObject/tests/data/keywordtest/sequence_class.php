<?php
/**
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
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
