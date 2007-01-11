<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
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
class ezcFeedRss1 extends ezcFeedRss
{
    protected $supportedModules = array();

    public function setFeedElement( $element, $value )
    {
    }

    public function setFeedItemElement( $item, $element, $value )
    {
    }

    public function getFeedElement( $element )
    {
    }

    public function getFeedItemElement( $item, $element )
    {
    }

    public function generate()
    {
    }

    public static function canParse( DomDocument $xml )
    {
        return false;
    }

    public function parse( DomDocument $xml )
    {
        return false;
    }

    public function parseItem( ezcFeed $feed, DomElement $xml )
    {
    }
}
?>
