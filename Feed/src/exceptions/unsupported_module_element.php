<?php
/**
 * File containing the ezcFeedUnsupportedModuleElementException class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Thrown when an unsupported element of a module is being set.
 *
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedUnsupportedModuleElementException extends ezcFeedException
{
    /**
     * Constructs a new ezcFeedUnsupportedModuleElementException.
     *
     * @param string $module The module which caused the exception
     * @param string $element The element which caused the exception
     */
    public function __construct( $module, $element )
    {
        parent::__construct( "The element '{$element}' does not exist for the module '{$module}'." );
    }
}
?>
