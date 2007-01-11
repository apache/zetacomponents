<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Feed
 */

/**
 * Thrown when some data is missing for a channel.
 *
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedRequiredMetaDataMissingException extends ezcFeedException
{
    function __construct( $attribute )
    {
        parent::__construct( "There was no data submitted for required channel attribute '{$attribute}'." );
    }
}
?>
