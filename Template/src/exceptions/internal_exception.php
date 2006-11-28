<?php
/**
 * File containing the ezcTemplateRuntimeException class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 *
 * @package Template
 * @version //autogen//
 */
class ezcTemplateInternalException extends Exception
{
    /**
     */
    public function __construct( $msg )
    {
        parent::__construct( "Internal error: $msg" );
    }
}

?>
