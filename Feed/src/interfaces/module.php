<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
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
