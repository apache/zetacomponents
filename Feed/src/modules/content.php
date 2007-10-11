<?php
/**
 * File containing the ezcFeedModuleContent class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Class for handling a Content feed module.
 *
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedModuleContent implements ezcFeedModule
{
    /**
     * Holds the feed type of this module (eg. 'rss2').
     *
     * @var string
     */
    protected $feedType;

    /**
     * Holds the supported elements for this module.
     *
     * @var array(string)
     */
    protected $supportedItemElements = array( 'encoded' );

    /**
     * Creates a new Content module with the feed type as $feedType.
     *
     * @param string $feedType The feed type of the new module
     */
    public function __construct( $feedType )
    {
        $this->feedType = $feedType;
    }

    /**
     * Returns the module name ('Content').
     *
     * @return string
     */
    public static function getModuleName()
    {
        return 'Content';
    }

    /**
     * Returns the namespace for this module ('http://purl.org/rss/1.0/modules/content/').
     *
     * @return string
     */
    public static function getNamespace()
    {
        return 'http://purl.org/rss/1.0/modules/content/';
    }

    /**
     * Returns the namespace prefix for this module ('content').
     *
     * @return string
     */
    public static function getNamespacePrefix()
    {
        return 'content';
    }

    /**
     * Returns true if the name $element is allowed as a channel element.
     *
     * @param string $element The name of the element
     * @return bool
     */
    public function isChannelElementAllowed( $element )
    {
        return false;
    }

    /**
     * Returns true if the name $element is allowed as an item element.
     *
     * @param string $element The name of the element
     * @return bool
     */
    public function isItemElementAllowed( $element )
    {
        return in_array( $element, $this->supportedItemElements );
    }

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
    public function feedMetaSetHook( $element, $value )
    {
        return null;
    }

    /**
     * Return true if setting the item $element to $value is allowed with the
     * module data $moduleData, false otherwise.
     *
     * It is a hook called before setting the feed $element to $value.
     *
     * @param array(string=>mixed) $moduleData The module data
     * @param string $element The name of the feed element
     * @param mixed $value The new value for $element
     * @return bool
     */
    public function feedMetaGenerateHook( $moduleData, $element, $value )
    {
        return true;
    }

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
    public function feedItemSetHook( $element, $value )
    {
        return null;
    }

    /**
     * Return true if setting the item $element to $value is allowed with the
     * item module data $moduleData, false otherwise.
     *
     * It is a hook called before setting the feed $element to $value.
     *
     * @param array(string=>mixed) $moduleData The item module data
     * @param string $element The name of the feed element
     * @param mixed $value The new value for $element
     * @return bool
     */
    public function feedItemGenerateHook( $moduleData, $element, $value )
    {
        return true;
    }

    public function generateMetaData( $feedProcessor, $element, $value )
    {
        die( "SHOUDL NOT BE CALLED" );
        $prefix = $this->getNamespacePrefix();
        switch ( $element )
        {
            default:
                $feedProcessor->generateMetaData( "$prefix:$element", $value );
                break;
        }
    }

    public function generateItemData( $itemTag, $feedProcessor, $element, $value )
    {
        $prefix = $this->getNamespacePrefix();
        switch ( $element )
        {
            default:
                $feedProcessor->generateItemData( $itemTag, "$prefix:$element", $value );
                break;
        }
    }
    
    public function prepareMetaData( $element, $value )
    {
        return $value;
    }
}
?>
