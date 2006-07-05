<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Feed
 */
/**
 * Thrown when a requested item number for a feed is out of range.
 *
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedItemNrOutOfRangeException extends ezcFeedException
{
    function __construct( $requested, $count )
    {
        $highNr = $count - 1;
        parent::__construct( "The given item number <{$requested}> is out of range <0..{$highNr}>." );
    }
}
?>
