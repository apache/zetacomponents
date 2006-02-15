<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Translation
 */
/**
 * Thrown by the getContext() method when a requested context doesn't exist.
 *
 * @package Translation
 */
class ezcTranslationContextNotAvailableException extends ezcTranslationException
{
    function __construct( $contextName )
    {
        parent::__construct( "The context <{$contextName}> does not exist." );
    }
}
?>
