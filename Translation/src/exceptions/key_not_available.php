<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Translation
 */
/**
 * Thrown by the getTranslation() method when a requested key doesn't exist.
 *
 * @package Translation
 */
class ezcTranslationKeyNotAvailableException extends ezcTranslationException
{
    function __construct( $keyName )
    {
        parent::__construct( "The key <{$keyName}> does not exist in the translation map." );
    }
}
?>
