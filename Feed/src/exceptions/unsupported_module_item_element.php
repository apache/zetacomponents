<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Feed
 */
/**
 * Thrown when an unsupported element of an item is being set.
 *
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedUnsupportedModuleItemElementException extends ezcFeedException
{
    function __construct( $module, $element )
    {
        parent::__construct( "The feed item element <{$element}> does not exist for the module <{$module}>." );
    }
}
?>
