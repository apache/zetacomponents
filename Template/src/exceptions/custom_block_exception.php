<?php
/**
 * File containing the ezcTemplateCustomBlockException class
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
class ezcTemplateCustomBlockException extends Exception
{
    /**
     * Initialises the CustomBlock exception with the given message.
     *
     * @param string $message
     */
    public function __construct( $message  )
    {
        parent::__construct( $message );
    }

}
?>
