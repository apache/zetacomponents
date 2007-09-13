<?php
/**
 * File containing the live property class.
 *
 * @package Webdav
 * @version //autogenetag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * An object of this class represents a Webdav live property.
 *
 * @version //autogenetag//
 * @package Webdav
 */
abstract class ezcWebdavLiveProperty extends ezcWebdavProperty
{
    /**
     * Creates a new live property.
     *
     * Creates a new live property with its class name as name and in the
     * default namespace "DAV:".
     * 
     * @param string $name
     * @return void
     */
    public function __construct( $name )
    {
        parent::__construct( 'DAV:', $name );
    }
}

?>
