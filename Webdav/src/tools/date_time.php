<?php
/**
 * File containing the ezcWebdavezcWebdavDateTime class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * This class extends the PHP internal ezcWebdavDateTime class to make it serializable.
 * This class is only needed for testing purposes and should be dropped ASAP,
 * if its parents issue is fixed.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License;
 *
 * @todo Remove
 */
class ezcWebdavDateTime extends DateTime
{
    /**
     * Stores the backup time in RFC 2822 format when being serialized.
     * 
     * @var string
     */
    private $backupTime;

    /**
     * Backup the currently stored time.
     * This methods backs up the time currently stored in the object as an RCF
     * 2822 formatted string and returns the name of the stored property in an
     * array to indicate that it should be serialized.
     * 
     * @return array(string)
     */
    public function __sleep()
    {
        $this->backupTime = $this->format( 'r' );
        return array( 'backupTime' );
    }

    /**
     * Restores the backeuped time.
     * 
     * @return void
     */
    public function __wakeup()
    {
        $this->__construct( $this->backupTime );
    }
}

?>
