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
 * Interface for feed modules.
 *
 * Currently implemented for these feed modules:
 *  - Content ({@link ezcFeedModuleContent})
 *  - DublinCore ({@link ezcFeedModuleDublinCore})
 *
 * @package Feed
 * @version //autogentag//
 */
interface ezcFeedModule
{
    /**
     * Returns the module name (eg. 'DublinCore').
     *
     * @return string
     */
    public static function getModuleName();

    /**
     * Returns the namespace for this module (eg. 'http://purl.org/dc/elements/1.1/').
     *
     * @return string
     */
    public static function getNamespace();

    /**
     * Returns the namespace prefix for this module (eg. 'dc').
     *
     * @return string
     */
    public static function getNamespacePrefix();

    /**
     * Returns true if the name $element is allowed as a channel element.
     *
     * @param string $element The name of the element
     * @return bool
     */
    public function isChannelElementAllowed( $element );

    /**
     * Returns true if the name $element is allowed as an item element.
     *
     * @param string $element The name of the element
     * @return bool
     */
    public function isItemElementAllowed( $element );

    /**
     * Return true if setting the item $element to $value is allowed, false
     * otherwise.
     *
     * It is a hook called before setting the feed $element to $value.
     *
     * @param string $element The name of the feed element
     * @param mixed $value The new value for $element
     * @return bool
     */
    public function feedMetaSetHook( $element, $value );

    /**
     * Return true if setting the item $element to $value is allowed with the
     * module data $moduleData, false otherwise.
     *
     * It is a hook called before setting the feed $element to $value.
     *
     * @param array(string=>mixed) The module data
     * @param string $element The name of the feed element
     * @param mixed $value The new value for $element
     * @return bool
     */
    public function feedMetaGenerateHook( $moduleData, $element, $value );

    /**
     * Return true if setting the item $element to $value is allowed, false
     * otherwise.
     *
     * It is a hook called before setting the item $element to $value.
     *
     * @param string $element The name of the item element
     * @param mixed $value The new value for $element
     * @return bool
     */
    public function feedItemSetHook( $element, $value );

    /**
     * Return true if setting the item $element to $value is allowed with the
     * item module data $moduleData, false otherwise.
     *
     * It is a hook called before setting the feed $element to $value.
     *
     * @param array(string=>mixed) The item module data
     * @param string $element The name of the feed element
     * @param mixed $value The new value for $element
     * @return bool
     */
    public function feedItemGenerateHook( $moduleData, $element, $value );
}
?>
