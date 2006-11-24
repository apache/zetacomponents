<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Feed
 * @access private
 */

/**
 * @package Feed
 * @version //autogentag//
 * @access private
 */
interface ezcFeedParser
{
    public static function canParse( DomDocument $xml );
    public function parse( DomDocument $xml );
    public function parseItem( ezcFeed $feed, DomElement $xml );
}
?>
