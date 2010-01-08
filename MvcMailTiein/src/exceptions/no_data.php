<?php
/**
 * File containing the ezcMvcMailNoDataException
 *
 * @package MvcMailTiein
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * This exception is thrown when no route matches the request.
 *
 * @package MvcMailTiein
 * @version //autogentag//
 */
class ezcMvcMailNoDataException extends ezcMvcMailTieinException
{
    /**
     * Constructs an ezcMvcMailNoDataException
     */
    public function __construct()
    {
        $message = "A valid mail message could not be found.";
        parent::__construct( $message );
    }
}
?>
