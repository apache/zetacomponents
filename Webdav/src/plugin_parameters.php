<?php
/**
 * File containing the ezcWebdavPluginParameters class.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Storage class submitted to callbacks assigned to plugin hooks.
 *
 * Instances of this storage class are submitted to plugins by the {@link
 * ezcWebdavPluginRegistry}. The contained elements may be evaluated by plugins
 * and, only if really necessary, be changed.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavPluginParameters extends ArrayObject
{
    /**
     * Create a new paramater storage.
     * 
     * @return void
     */
    public function __construct()
    {
        $parameters = array();
        parent::__construct( $parameters );
    }
}

?>
