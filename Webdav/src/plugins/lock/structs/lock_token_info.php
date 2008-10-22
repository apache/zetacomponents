<?php
/**
 * File containing the ezcWebdavLockTokenInfo struct class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Struct used in {@link ezcWebdavLockInfoProperty}.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavLockTokenInfo extends ezcBaseStruct
{
    /**
     * Lock token this information is about 
     * 
     * @var string
     */
    public $token;

    /**
     * Base path of the lock. 
     * 
     * @var string
     */
    public $lockBase;

    /**
     * Last access time of the lock by a client.
     * 
     * @var DateTime
     */
    public $lastAccess;

    /**
     * Creates a new lock token info struct.
     * 
     * @param string $token 
     * @param string $lockBase 
     * @param DateTime $lastAccess 
     */
    public function __construct( $token = null, $lockBase = null, $lastAccess = null )
    {
        $this->token      = $token;
        $this->lockBase   = $lockBase;
        $this->lastAccess = $lastAccess;
    }
}

?>
