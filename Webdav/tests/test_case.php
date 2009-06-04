<?php
/**
 * File containing the webdav base test case class.
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Extended test case to backup and restore $_SERVER array, to make it possible
 * to fake values in there.
 * 
 * @package Webdav
 * @version //autogentag//
 */
class ezcWebdavTestCase extends ezcTestCase
{
    /**
     * Backup server array before running a test and restor it afterwards.
     *
     * Property may be modified in setup method to omit this behaviour.
     * 
     * @var bool
     */
    protected $backupServerArray = true;

    /**
     * Runs the bare test sequence.
     *
     * @access public
     */
    public function runBare()
    {
        // Backup server array if requested
        if ( $this->backupServerArray )
        {
            $serverBackup = $_SERVER;
        }

        // Run original test method
        parent::runBare();

        // Restore server array
        if ( $this->backupServerArray )
        {
            $_SERVER = $serverBackup;
        }
    }

    protected function setUp()
    {
        ezcWebdavServer::getInstance()->reset();
    }
}

?>
