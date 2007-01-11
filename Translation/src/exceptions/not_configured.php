<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Translation
 */

/**
 * Thrown when a required configuration setting was not made for a backend.
 *
 * @package Translation
 * @version //autogentag//
 */
class ezcTranslationNotConfiguredException extends ezcTranslationException
{
    function __construct( $location )
    {
        parent::__construct( "Location '{$location}' is invalid." );
    }
}
?>
