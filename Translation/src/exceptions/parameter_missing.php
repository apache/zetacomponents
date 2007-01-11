<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Translation
 */

/**
 * Thrown by the getTranslation() method when a paramater was missing
 * to a parameterized translation string.
 *
 * @package Translation
 * @version //autogentag//
 */
class ezcTranslationParameterMissingException extends ezcTranslationException
{
    function __construct( $parameterName )
    {
        parent::__construct( "The parameter '%{$parameterName}' does not exist." );
    }
}
?>
