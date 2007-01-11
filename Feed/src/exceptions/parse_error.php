<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Feed
 */

/**
 * Thrown when a feed can not be parsed at all.
 *
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedParseErrorException extends ezcFeedException
{
    function __construct( $extraData )
    {
        parent::__construct( "Parse error while parsing feed: {$extraData}." );
    }
}
?>
