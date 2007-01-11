<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Feed
 */

/**
 * Thrown when an unsupported feed is created.
 *
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedUnsupportedTypeException extends ezcFeedException
{
    function __construct( $type )
    {
        parent::__construct( "The feed type '{$type}' is not supported." );
    }
}
?>
