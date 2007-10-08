<?php
/**
 * File containing the ezcFeedUnsupportedModuleException class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Thrown when an unsupported feed is created.
 *
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedUnsupportedModuleException extends ezcFeedException
{
    function __construct( $type )
    {
        parent::__construct( "The module '{$type}' is not supported." );
    }
}
?>
