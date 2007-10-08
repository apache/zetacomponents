<?php
/**
 * File containing the ezcFeedUnsupportedModuleItemElementException class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Thrown when an unsupported element of an item is being set.
 *
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedUnsupportedModuleItemElementException extends ezcFeedException
{
    /**
     * Constructs a new ezcFeedUnsupportedModuleItemElementException.
     *
     * @param string $module The module which caused the exception
     * @param string $element The element which caused the exception
     */
    public function __construct( $module, $element )
    {
        parent::__construct( "The feed item element '{$element}' does not exist for the module '{$module}'." );
    }
}
?>
