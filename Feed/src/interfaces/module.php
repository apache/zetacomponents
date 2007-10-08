<?php
/**
 * File containing the ezcFeedModule interface.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * @package Feed
 * @version //autogentag//
 */
interface ezcFeedModule
{
    public static function getModuleName();
    public static function getNamespace();
    public static function getNamespacePrefix();
    public function feedMetaSetHook( &$element, &$value );
    public function feedItemSetHook( &$element, &$value );
    public function isChannelElementAllowed( $element );
    public function isItemElementAllowed( $element );
}
?>
