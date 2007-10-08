<?php
/**
 * File containing the ezcFeedCanNotParseException class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Thrown when a feed can not be parsed at all.
 *
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedCanNotParseException extends ezcFeedException
{
    function __construct( $uri, $extraData )
    {
        parent::__construct( "The feed '{$uri}' could not be parsed: {$extraData}." );
    }
}
?>
