<?php
/**
 * File containing the ezcFeedParser interface.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * @package Feed
 * @version //autogentag//
 */
interface ezcFeedParser
{
    public static function canParse( DomDocument $xml );
    public function parse( DomDocument $xml );
    public function parseItem( ezcFeed $feed, DomElement $xml );
}
?>
