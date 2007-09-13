<?php
/**
 * File containing the ezcWebdavInvalidRequestMethodException class.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Thrown if an unknwon request method is received.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavInvalidRequestMethodException extends ezcWebdavException
{
    public function __construct( $method )
    {
        parent::__construct( "The HTTP request method '$method' was not understood." );
    }
}

?>
