<?php
/**
 * File containing the ezcWebdavBasicAuth struct.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Struct containing digest authentication information.
 *
 * This struct represents authentication data as provided by the HTTP Basic
 * specification.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @author  
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavBasicAuth extends ezcBaseStruct
{
    /**
     * Plain text user name.
     * 
     * @var string
     */
    public $username;

    /**
     * Plain text password. 
     * 
     * @var string
     */
    public $password;
}

?>
