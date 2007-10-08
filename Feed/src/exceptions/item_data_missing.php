<?php
/**
 * File containing the ezcFeedRequiredItemDataMissingException class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Thrown when some data is missing for a feed item.
 *
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedRequiredItemDataMissingException extends ezcFeedException
{
    /**
     * Constructs a new ezcFeedRequiredItemDataMissingException.
     *
     * @param string $attribute The attribute which caused the exception
     */
    public function __construct( $attribute )
    {
        parent::__construct( "There was no data submitted for required attribute '{$attribute}'." );
    }
}
?>
