<?php
/**
 * File containing the ezcFeedParseErrorException class.
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
class ezcFeedParseErrorException extends ezcFeedException
{
    function __construct( $extraData )
    {
        parent::__construct( "Parse error while parsing feed: {$extraData}." );
    }
}
?>
