<?php
/**
 * File containing the ezcSearchException class.
 *
 * @package Search
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * This class provides the base exception for exception in the Search component.
 *
 * @package Search
 * @version //autogentag//
 */
abstract class ezcSearchException extends ezcBaseException
{
    /**
     * Constructs an ezcSearchException
     *
     * @param string $message
     * @return void
     */
    public function __construct( $message )
    {
        parent::__construct( $message );
    }
}
?>
