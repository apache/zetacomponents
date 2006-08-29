<?php
/**
 * File containing the ezcTestDatabaseSettings class
 *
 * @package UnitTest
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

ezcTestRunner::addFileToFilter( __FILE__ );

/**
 * This class represents the structure of all the database settings.
 * 
 * @package UnitTest
 * @version //autogen//
 */
class ezcTestDatabaseSettings
{
    public $dsn;

    public $phptype;

    public $dbsyntax;
    
    public $username;
    
    public $password;

    public $protocol;

    public $hostspec;
    
    public $port;

    public $socket;

    public $database;
}
?>
