<?php
/**
 * File containing the ezcWebdavAuth struct.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Base struct for authentication credentials.
 * 
 * @package Webdav
 * @version //autogen//
 */
abstract class ezcWebdavAuth extends ezcBaseStruct
{
    /**
     * Username. 
     * 
     * @var string
     */
    public $username = '';

    /**
     * Creates a new credential struct.
     * 
     * @param string $username 
     */
    public function __construct( $username = '' )
    {
        $this->username = $username;
    }
}

?>
