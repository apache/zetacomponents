<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Feed
 */

/**
 * Thrown when some data is missing for a feed item.
 *
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedRequiredItemDataMissingException extends ezcFeedException
{
    function __construct( $attribute )
    {
        parent::__construct( "There was no data submitted for required attribute '{$attribute}'." );
    }
}
?>
