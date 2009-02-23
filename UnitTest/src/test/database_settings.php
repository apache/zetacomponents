<?php
/**
 * File containing the ezcTestDatabaseSettings class.
 *
 * @package UnitTest
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'PHPUnit/Util/Filter.php';

PHPUnit_Util_Filter::addFileToFilter(__FILE__, 'PHPUNIT');

/**
 * This class represents the structure of all the database settings.
 * 
 * @package UnitTest
 * @version //autogentag//
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
