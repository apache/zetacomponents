<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Feed
 */

/**
 * Thrown when some elements value is not a single value but an array.
 *
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedOnlyOneValueAllowedException extends ezcFeedException
{
    function __construct( $attribute )
    {
        parent::__construct( "The attribute '{$attribute}' supports only singular values." );
    }
}
?>
