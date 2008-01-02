<?php
/**
 * File containing the ezcFeedParseErrorException class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
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
    /**
     * Constructs a new ezcFeedParseErrorException.
     *
     * @param string $extraData An extra message to be included in the thrown exception text
     */
    public function __construct( $extraData )
    {
        parent::__construct( "Parse error while parsing feed: {$extraData}." );
    }
}
?>
